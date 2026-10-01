<?php
/** Run only on a development copy: php tests/access-control.php /path/to/wp-load.php */
if ( PHP_SAPI !== 'cli' || empty( $argv[1] ) ) { exit( 1 ); }
define( 'WP_ADMIN', true );
$_SERVER['SERVER_NAME'] = 'localhost';
require $argv[1];
require_once ABSPATH . 'wp-admin/includes/user.php';
require_once ABSPATH . 'wp-admin/includes/post.php';
function tt_access_check( $ok, $message ) {
	if ( ! $ok ) { throw new RuntimeException( $message ); }
	echo "PASS: $message\n";
}
$created_user = false;
$term_id = 0;
$original_user = get_current_user_id();
$user = get_user_by( 'login', 'admtakaros' );
if ( ! $user ) {
	$id = wp_insert_user( array( 'user_login' => 'admtakaros', 'user_pass' => wp_generate_password( 40 ), 'role' => 'subscriber' ) );
	if ( is_wp_error( $id ) ) { throw new RuntimeException( $id->get_error_message() ); }
	$created_user = true;
	$user = get_userdata( $id );
}
try {
	if ( $created_user ) {
		$user->set_role( 'administrator' );
		$user->add_cap( 'manage_options' );
		teamtakaros_content_user_baseline();
		$user = get_userdata( $user->ID );
		tt_access_check( array( 'subscriber' => true ) === $user->caps, 'Stored role and individual privileges are reduced to Subscriber' );
	}
	wp_set_current_user( $user->ID );
	tt_access_check( current_user_can( 'read' ) && current_user_can( 'upload_files' ) && current_user_can( 'tt_manage_site_content' ), 'Named account can read, upload media, and edit Site Content' );
	foreach ( array( 'manage_options', 'edit_posts', 'edit_pages', 'publish_posts', 'delete_posts', 'list_users', 'create_users', 'promote_users', 'activate_plugins', 'install_plugins', 'edit_themes', 'switch_themes', 'unfiltered_html', 'unfiltered_upload', 'administrator' ) as $cap ) {
		tt_access_check( ! current_user_can( $cap ), 'Denied capability: ' . $cap );
	}
	$filtered = teamtakaros_content_user_caps( array( 'manage_options' => true, 'administrator' => true ), array(), array(), $user );
	tt_access_check( empty( $filtered['manage_options'] ) && empty( $filtered['administrator'] ), 'Stored administrator capabilities cannot bypass restrictions' );
	$photo = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 1 ) )[0];
	tt_access_check( current_user_can( 'edit_post', $photo->ID ) && current_user_can( 'delete_post', $photo->ID ), 'Existing attachments can be edited and deleted' );
	$post = get_posts( array( 'post_type' => array( 'post', 'page' ), 'posts_per_page' => 1 ) )[0];
	tt_access_check( ! current_user_can( 'edit_post', $post->ID ) && ! current_user_can( 'delete_post', $post->ID ), 'Posts and pages cannot be edited or deleted' );
	$translated = _wp_translate_postdata( true, array( 'ID' => $photo->ID, 'post_ID' => $photo->ID, 'post_type' => 'attachment', 'post_author' => $photo->post_author, 'post_status' => 'inherit', 'post_title' => $photo->post_title ) );
	tt_access_check( ! is_wp_error( $translated ), 'Media editor accepts an existing image owned by another account' );
	$taxonomy = get_taxonomy( 'tt_work_tab' );
	tt_access_check( current_user_can( $taxonomy->cap->manage_terms ), 'Gallery tab management is permitted' );
	$term = wp_insert_term( 'Access regression ' . uniqid(), 'tt_work_tab' );
	if ( is_wp_error( $term ) ) { throw new RuntimeException( $term->get_error_message() ); }
	$term_id = $term['term_id'];
	tt_access_check( current_user_can( 'edit_term', $term_id ) && current_user_can( 'delete_term', $term_id ), 'Gallery tab edit and delete permissions work' );
	foreach ( teamtakaros_content_pages() as $page ) {
		tt_access_check( teamtakaros_content_admin_allowed( 'admin.php', array( 'page' => $page ) ) && teamtakaros_content_admin_allowed( 'admin-post.php', array( 'action' => $page ), 'POST' ), 'Allowed content editor and save: ' . $page );
	}
	foreach ( array( 'options-general.php', 'options.php', 'plugins.php', 'themes.php', 'users.php', 'profile.php', 'edit.php', 'post-new.php' ) as $page ) {
		tt_access_check( ! teamtakaros_content_admin_allowed( $page, array() ), 'Direct dashboard URL denied: ' . $page );
	}
	tt_access_check( ! teamtakaros_content_admin_allowed( 'admin.php', array( 'page' => 'wpcf7' ) ), 'Other plugin pages are denied' );
	tt_access_check( ! teamtakaros_content_admin_allowed( 'upload.php', array( 'page' => 'other-plugin' ) ), 'Plugin subpages cannot bypass the Media allowlist' );
	tt_access_check( ! teamtakaros_content_admin_allowed( 'upload.php', array( 'action' => '-1', 'action2' => 'plugin_bulk_action' ) ), 'Secondary bulk actions cannot bypass the allowlist' );
	tt_access_check( teamtakaros_content_admin_allowed( 'post.php', array( 'action' => 'editpost', 'post_ID' => $photo->ID ), 'POST' ) && ! teamtakaros_content_admin_allowed( 'post.php', array( 'action' => 'edit', 'post' => $post->ID ) ), 'Direct post handler is restricted to attachments' );
	foreach ( array( 'upload-attachment', 'query-attachments', 'save-attachment', 'image-editor', 'heartbeat' ) as $action ) {
		tt_access_check( teamtakaros_content_admin_allowed( 'admin-ajax.php', array( 'action' => $action ), 'POST' ), 'Required media AJAX allowed: ' . $action );
	}
	tt_access_check( ! teamtakaros_content_admin_allowed( 'admin-ajax.php', array( 'action' => 'install-plugin' ), 'POST' ), 'Other AJAX actions denied' );
	tt_access_check( ! teamtakaros_content_admin_allowed( 'admin-ajax.php', array( 'action' => 'add-tag', 'taxonomy' => 'category' ), 'POST' ), 'Other taxonomies denied' );
	$box = CMB2_Boxes::get( 'teamtakaros_content_box_header' );
	tt_access_check( current_user_can( $box->prop( 'capability' ) ) && apply_filters( 'cmb2_can_save', true, $box ), 'CMB2 content screen and save capability are allowed' );
	$request = new WP_REST_Request( 'POST', '/wp/v2/posts' );
	tt_access_check( 403 === rest_do_request( $request )->get_status(), 'Authenticated post API is blocked' );
	$request = new WP_REST_Request( 'GET', '/wp/v2/settings' );
	tt_access_check( 403 === rest_do_request( $request )->get_status(), 'Authenticated settings API is blocked' );
	$request = new WP_REST_Request( 'GET', '/wp/v2/media/' . $photo->ID );
	$request->set_param( 'context', 'edit' );
	tt_access_check( 200 === rest_do_request( $request )->get_status(), 'Media API editing context remains available' );
	$controller = new WP_REST_Attachments_Controller( 'attachment' );
	tt_access_check( true === $controller->create_item_permissions_check( new WP_REST_Request( 'POST', '/wp/v2/media' ) ), 'Media upload API permission remains available without post creation rights' );
	$admins = get_users( array( 'role' => 'administrator', 'exclude' => array( $user->ID ), 'number' => 1 ) );
	wp_set_current_user( $admins[0]->ID );
	tt_access_check( current_user_can( 'manage_options' ) && current_user_can( 'tt_manage_site_content' ) && current_user_can( 'edit_post', $photo->ID ), 'Other administrators retain their access' );
	echo "All account access checks passed.\n";
} finally {
	if ( $term_id ) { wp_delete_term( $term_id, 'tt_work_tab' ); }
	wp_set_current_user( $original_user );
	if ( $created_user ) { wp_delete_user( $user->ID ); }
}
