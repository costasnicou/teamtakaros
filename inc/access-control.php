<?php
/** Restrict the admtakaros account to site content and media. @package teamtakaros */
if ( ! defined( 'ABSPATH' ) ) { exit; }

function teamtakaros_is_content_user( $user = null ) {
	$user = null === $user ? wp_get_current_user() : $user;
	return $user instanceof WP_User && $user->exists() && 'admtakaros' === strtolower( $user->user_login );
}

/** Persist a minimal role so switching themes does not restore old admin rights. */
function teamtakaros_content_user_baseline() {
	$user = get_user_by( 'login', 'admtakaros' );
	if ( $user && array( 'subscriber' => true ) !== $user->caps ) {
		$user->remove_all_caps();
		$user->set_role( 'subscriber' );
	}
}
add_action( 'init', 'teamtakaros_content_user_baseline', 5 );

/** Give Media its own primitive capabilities instead of sharing post permissions. */
function teamtakaros_media_capabilities() {
	return array(
		'create_posts' => 'edit_posts', 'edit_posts' => 'edit_posts',
		'edit_others_posts' => 'edit_others_posts', 'edit_published_posts' => 'edit_published_posts',
		'edit_private_posts' => 'edit_private_posts', 'publish_posts' => 'publish_posts',
		'delete_posts' => 'delete_posts', 'delete_others_posts' => 'delete_others_posts',
		'delete_published_posts' => 'delete_published_posts', 'delete_private_posts' => 'delete_private_posts',
		'read_private_posts' => 'read_private_posts',
	);
}

function teamtakaros_media_post_type_caps( $args, $post_type ) {
	if ( 'attachment' === $post_type ) {
		foreach ( teamtakaros_media_capabilities() as $property => $original ) {
			$args['capabilities'][ $property ] = 'tt_media_' . $property;
		}
	}
	return $args;
}
add_filter( 'register_post_type_args', 'teamtakaros_media_post_type_caps', 10, 2 );

/** A dedicated capability avoids granting access to WordPress Settings. */
function teamtakaros_content_user_caps( $allcaps, $caps, $args, $user ) {
	if ( teamtakaros_is_content_user( $user ) ) {
		return array( 'read' => true, 'upload_files' => true, 'tt_manage_site_content' => true );
	}
	return $allcaps;
}
add_filter( 'user_has_cap', 'teamtakaros_content_user_caps', PHP_INT_MAX, 4 );

function teamtakaros_content_meta_caps( $caps, $cap, $user_id, $args ) {
	$user = get_userdata( $user_id );
	foreach ( teamtakaros_media_capabilities() as $property => $original ) {
		if ( 'tt_media_' . $property === $cap ) {
			return array( teamtakaros_is_content_user( $user ) ? 'upload_files' : $original );
		}
	}
	if ( ! teamtakaros_is_content_user( $user ) ) {
		if ( 'tt_manage_site_content' === $cap ) { return array( 'manage_options' ); }
		$media_caps = teamtakaros_media_capabilities();
		return array_map( function( $required ) use ( $media_caps ) {
			$key = substr( $required, 9 );
			return 0 === strpos( $required, 'tt_media_' ) && isset( $media_caps[ $key ] ) ? $media_caps[ $key ] : $required;
		}, $caps );
	}
	$allowed = array( 'read', 'upload_files', 'tt_manage_site_content' );
	if ( in_array( $cap, $allowed, true ) ) {
		return array( $cap );
	}
	// Media can be edited without granting edit_posts or page-editing capabilities.
	if ( in_array( $cap, array( 'edit_post', 'delete_post', 'read_post' ), true ) && ! empty( $args[0] ) && 'attachment' === get_post_type( $args[0] ) ) {
		return array( 'upload_files' );
	}
	// Preserve core object/meta checks, including explicit do_not_allow results.
	if ( ! empty( $caps ) && ! array_diff( $caps, $allowed ) ) {
		return $caps;
	}
	return array( 'do_not_allow' );
}
add_filter( 'map_meta_cap', 'teamtakaros_content_meta_caps', PHP_INT_MAX, 4 );

function teamtakaros_content_pages() {
	return array_map( function( $section ) { return 'teamtakaros_content_' . $section; }, array_keys( teamtakaros_content_schema() ) );
}

/** Pure allowlist shared by request enforcement and regression checks. */
function teamtakaros_content_admin_allowed( $page, $request, $method = 'GET' ) {
	$action = isset( $request['action'] ) && is_string( $request['action'] ) ? $request['action'] : '';
	if ( in_array( $action, array( '', '-1' ), true ) && isset( $request['action2'] ) && is_string( $request['action2'] ) && '-1' !== $request['action2'] ) {
		$action = $request['action2'];
	}
	$plugin_page = isset( $request['page'] ) && is_string( $request['page'] ) ? $request['page'] : '';
	if ( $plugin_page && ( 'admin.php' !== $page || ! in_array( $plugin_page, teamtakaros_content_pages(), true ) ) ) {
		return false;
	}
	if ( 'admin.php' === $page ) {
		return '' === $action && in_array( $plugin_page, teamtakaros_content_pages(), true );
	}
	if ( 'admin-post.php' === $page ) {
		return 'POST' === $method && in_array( $action, teamtakaros_content_pages(), true );
	}
	if ( in_array( $page, array( 'edit-tags.php', 'term.php' ), true ) ) {
		return isset( $request['taxonomy'] ) && 'tt_work_tab' === $request['taxonomy'] && in_array( $action, array( '', '-1', 'add-tag', 'edit', 'editedtag', 'delete', 'bulk-delete' ), true );
	}
	if ( 'post.php' === $page ) {
		$id = isset( $request['post_ID'] ) ? absint( $request['post_ID'] ) : ( isset( $request['post'] ) ? absint( $request['post'] ) : 0 );
		return $id && 'attachment' === get_post_type( $id ) && in_array( $action, array( 'edit', 'editpost', 'delete', 'trash', 'untrash' ), true );
	}
	if ( 'admin-ajax.php' === $page ) {
		if ( in_array( $action, array( 'add-tag', 'delete-tag', 'inline-save-tax', 'get-tagcloud', 'ajax-tag-search' ), true ) ) {
			return isset( $request['taxonomy'] ) && 'tt_work_tab' === $request['taxonomy'];
		}
		return in_array( $action, array(
			'query-attachments', 'get-attachment', 'upload-attachment', 'save-attachment',
			'save-attachment-compat', 'save-attachment-order', 'send-attachment-to-editor',
			'delete-post', 'image-editor', 'imgedit-preview', 'crop-image', 'media-create-image-subsizes',
			'heartbeat', 'wp-auth-check', 'logged-in', 'hidden-columns', 'closed-postboxes', 'meta-box-order',
		), true );
	}
	if ( 'async-upload.php' === $page ) {
		return in_array( $action, array( '', 'upload-attachment' ), true );
	}
	if ( 'upload.php' === $page ) {
		return in_array( $action, array( '', '-1', 'delete', 'trash', 'untrash', 'delete_all', 'detach', 'attach' ), true );
	}
	return in_array( $page, array( 'media-new.php', 'media.php' ), true ) && in_array( $action, array( '', 'edit', 'editattachment' ), true );
}

function teamtakaros_content_admin_guard() {
	if ( ! teamtakaros_is_content_user() ) { return; }
	global $pagenow;
	if ( 'index.php' === $pagenow && 'GET' === $_SERVER['REQUEST_METHOD'] ) {
		wp_safe_redirect( admin_url( 'admin.php?page=teamtakaros_content_header' ) );
		exit;
	}
	if ( ! teamtakaros_content_admin_allowed( $pagenow, wp_unslash( $_REQUEST ), $_SERVER['REQUEST_METHOD'] ) ) {
		wp_die( esc_html__( 'This account can access only Site Content and Media.', 'teamtakaros' ), '', array( 'response' => 403 ) );
	}
}
add_action( 'admin_init', 'teamtakaros_content_admin_guard', 0 );

function teamtakaros_content_menus() {
	if ( ! teamtakaros_is_content_user() ) { return; }
	global $menu, $submenu;
	$allowed = array( 'upload.php', 'teamtakaros_content_header' );
	foreach ( $menu as $entry ) {
		if ( ! in_array( $entry[2], $allowed, true ) ) { remove_menu_page( $entry[2] ); }
	}
	foreach ( (array) $submenu as $parent => $entries ) {
		foreach ( $entries as $entry ) {
			$link = html_entity_decode( $entry[2], ENT_QUOTES, 'UTF-8' );
			$allowed_links = array_merge( teamtakaros_content_pages(), array( 'upload.php', 'media-new.php', 'edit-tags.php?taxonomy=tt_work_tab&post_type=attachment' ) );
			if ( ! in_array( $parent, $allowed, true ) || ! in_array( $link, $allowed_links, true ) ) {
				remove_submenu_page( $parent, $entry[2] );
			}
		}
	}
}
add_action( 'admin_menu', 'teamtakaros_content_menus', PHP_INT_MAX );

function teamtakaros_content_login_redirect( $redirect, $requested, $user ) {
	return teamtakaros_is_content_user( $user ) ? admin_url( 'admin.php?page=teamtakaros_content_header' ) : $redirect;
}
add_filter( 'login_redirect', 'teamtakaros_content_login_redirect', 10, 3 );

function teamtakaros_content_admin_bar( $bar ) {
	if ( ! teamtakaros_is_content_user() ) { return; }
	foreach ( array( 'wp-logo', 'site-name', 'updates', 'comments', 'new-content', 'customize', 'edit', 'my-account' ) as $id ) { $bar->remove_node( $id ); }
	$bar->add_node( array( 'id' => 'tt-view-site', 'title' => __( 'Visit site', 'teamtakaros' ), 'href' => home_url( '/' ) ) );
	$bar->add_node( array( 'id' => 'tt-content', 'title' => __( 'Site Content', 'teamtakaros' ), 'href' => admin_url( 'admin.php?page=teamtakaros_content_header' ) ) );
	$bar->add_node( array( 'id' => 'tt-logout', 'parent' => 'top-secondary', 'title' => __( 'Log out', 'teamtakaros' ), 'href' => wp_logout_url() ) );
}
add_action( 'admin_bar_menu', 'teamtakaros_content_admin_bar', PHP_INT_MAX );

/** Block other authenticated API routes as well as their dashboard screens. */
function teamtakaros_content_rest_guard( $result, $server, $request ) {
	if ( ! teamtakaros_is_content_user() ) { return $result; }
	$route = $request->get_route();
	if ( preg_match( '#^/wp/v2/media(?:/\d+(?:/edit|/post-process)?)?/?$#', $route ) || '/teamtakaros/v1/gallery' === $route ) {
		return $result; // WordPress still applies its normal endpoint capabilities/nonces.
	}
	return new WP_Error( 'tt_content_access_denied', __( 'This account can access only Site Content and Media.', 'teamtakaros' ), array( 'status' => 403 ) );
}
add_filter( 'rest_pre_dispatch', 'teamtakaros_content_rest_guard', 10, 3 );

/** Keep explicit authorization on content saves in addition to CMB2's nonce. */
function teamtakaros_content_save_permission( $can_save, $box ) {
	if ( array_intersect( (array) $box->prop( 'option_key' ), teamtakaros_content_pages() ) || 'tt_gallery_tab_fields' === $box->cmb_id ) {
		return $can_save && current_user_can( 'tt_manage_site_content' );
	}
	return teamtakaros_is_content_user() ? false : $can_save;
}
add_filter( 'cmb2_can_save', 'teamtakaros_content_save_permission', 10, 2 );
