<?php
/** Dashboard-managed, two-level work gallery. @package teamtakaros */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Media → Our Work tabs provides native create, edit, and delete screens. */
function teamtakaros_register_gallery() {
	register_taxonomy( 'tt_work_tab', 'attachment', array(
		'labels' => array(
			'name' => __( 'Our Work tabs', 'teamtakaros' ),
			'singular_name' => __( 'Gallery tab', 'teamtakaros' ),
			'menu_name' => __( 'Our Work tabs', 'teamtakaros' ),
			'add_new_item' => __( 'Add gallery tab', 'teamtakaros' ),
			'edit_item' => __( 'Edit gallery tab', 'teamtakaros' ),
			'parent_item' => __( 'Parent tab', 'teamtakaros' ),
			'parent_item_colon' => __( 'Parent tab:', 'teamtakaros' ),
			'search_items' => __( 'Search gallery tabs', 'teamtakaros' ),
			'not_found' => __( 'No gallery tabs found.', 'teamtakaros' ),
		),
		'hierarchical' => true,
		'public' => false,
		'show_ui' => true,
		'show_in_menu' => true,
		'show_in_rest' => false,
		'show_in_nav_menus' => false,
		'show_admin_column' => false,
		'meta_box_cb' => false,
		'rewrite' => false,
		'capabilities' => array(
			'manage_terms' => 'manage_options', 'edit_terms' => 'manage_options',
			'delete_terms' => 'manage_options', 'assign_terms' => 'manage_options',
		),
	) );
}
add_action( 'init', 'teamtakaros_register_gallery' );

/** Only direct children of top-level tabs can hold a photo collection. */
function teamtakaros_gallery_child( $id ) {
	$term = get_term( (int) $id, 'tt_work_tab' );
	if ( ! $term || is_wp_error( $term ) || ! $term->parent ) {
		return false;
	}
	$parent = get_term( $term->parent, 'tt_work_tab' );
	return $parent && ! is_wp_error( $parent ) && ! $parent->parent ? $term : false;
}

function teamtakaros_gallery_parent_dropdown( $args, $taxonomy ) {
	if ( 'tt_work_tab' === $taxonomy ) {
		$args['parent'] = 0;
		$args['option_none_value'] = 0;
	}
	return $args;
}
add_filter( 'taxonomy_parent_dropdown_args', 'teamtakaros_gallery_parent_dropdown', 10, 2 );

function teamtakaros_gallery_insert_term( $name, $taxonomy, $args ) {
	$args = wp_parse_args( $args );
	// WordPress submits -1 for None and normalizes it to 0 after this hook.
	if ( 'tt_work_tab' === $taxonomy && isset( $args['parent'] ) && (int) $args['parent'] > 0 ) {
		$parent = get_term( (int) $args['parent'], $taxonomy );
		if ( ! $parent || is_wp_error( $parent ) || $parent->parent ) {
			return new WP_Error( 'gallery_depth', __( 'Choose a top-level parent tab. The gallery supports two levels.', 'teamtakaros' ) );
		}
	}
	return $name;
}
add_filter( 'pre_insert_term', 'teamtakaros_gallery_insert_term', 10, 3 );

function teamtakaros_gallery_update_parent( $parent, $id, $taxonomy ) {
	if ( 'tt_work_tab' !== $taxonomy || ! $parent ) {
		return $parent;
	}
	$target = get_term( $parent, $taxonomy );
	$children = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => $id, 'hide_empty' => false, 'fields' => 'ids' ) );
	if ( ! $target || is_wp_error( $target ) || $target->parent || $parent === $id || ! empty( $children ) ) {
		$old = get_term( $id, $taxonomy );
		return $old && ! is_wp_error( $old ) ? (int) $old->parent : 0;
	}
	return $parent;
}
add_filter( 'wp_update_term_parent', 'teamtakaros_gallery_update_parent', 20, 3 );

/** Deleting a parent removes its tabs, but never deletes Media Library files. */
function teamtakaros_gallery_delete_children( $id, $taxonomy ) {
	if ( 'tt_work_tab' !== $taxonomy ) {
		return;
	}
	$children = get_terms( array( 'taxonomy' => $taxonomy, 'parent' => $id, 'hide_empty' => false, 'fields' => 'ids' ) );
	if ( ! is_wp_error( $children ) ) {
		foreach ( $children as $child ) {
			wp_delete_term( $child, $taxonomy );
		}
	}
}
add_action( 'pre_delete_term', 'teamtakaros_gallery_delete_children', 10, 2 );

function teamtakaros_gallery_photo_field_visible( $field ) {
	return (bool) teamtakaros_gallery_child( $field->object_id );
}

/** Store only actual image attachment IDs; never trust submitted file URLs. */
function teamtakaros_gallery_sanitize_photos( $value ) {
	$images = array();
	foreach ( (array) $value as $id => $unused_url ) {
		$id = absint( $id );
		if ( $id && wp_attachment_is_image( $id ) && 'inherit' === get_post_field( 'post_status', $id, 'raw' ) ) {
			$images[ $id ] = wp_get_attachment_url( $id );
		}
	}
	return $images;
}

function teamtakaros_gallery_fields() {
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		return;
	}
	$box = new_cmb2_box( array(
		'id' => 'tt_gallery_tab_fields',
		'object_types' => array( 'term' ),
		'taxonomies' => array( 'tt_work_tab' ),
		'new_term_section' => false,
	) );
	$box->add_field( array(
		'id' => '_tt_gallery_order', 'name' => __( 'Tab order', 'teamtakaros' ),
		'type' => 'text_small', 'default' => 0, 'sanitization_cb' => 'absint',
		'attributes' => array( 'type' => 'number', 'min' => 0, 'step' => 1 ),
		'desc' => __( 'Lower numbers appear first among tabs at the same level.', 'teamtakaros' ),
	) );
	$box->add_field( array(
		'id' => '_tt_gallery_photos', 'name' => __( 'Photos', 'teamtakaros' ),
		'type' => 'file_list', 'query_args' => array( 'type' => 'image' ),
		'preview_size' => array( 120, 90 ),
		'show_on_cb' => 'teamtakaros_gallery_photo_field_visible',
		'sanitization_cb' => 'teamtakaros_gallery_sanitize_photos',
		'desc' => __( 'Upload multiple photos or select images from the Media Library, then click Update. Photos appear newest upload first, regardless of their order here. Remove an image here to remove it only from this tab. Edit its alt text in the Media Library.', 'teamtakaros' ),
	) );
}
add_action( 'cmb2_admin_init', 'teamtakaros_gallery_fields' );

function teamtakaros_gallery_admin_help() {
	$screen = get_current_screen();
	if ( ! $screen || 'tt_work_tab' !== $screen->taxonomy ) {
		return;
	}
	echo '<div class="notice notice-info"><p>' . esc_html__( 'Create a parent tab with Parent tab set to None. Create a second tab beneath it, then edit that child tab to upload its photos. Two levels are supported. Deleting a parent also deletes its child tabs; image files remain in the Media Library.', 'teamtakaros' ) . '</p></div>';
	if ( ! function_exists( 'new_cmb2_box' ) ) {
		echo '<div class="notice notice-warning"><p>' . esc_html__( 'Activate CMB2 to upload photos and set tab order.', 'teamtakaros' ) . '</p></div>';
	}
}
add_action( 'admin_notices', 'teamtakaros_gallery_admin_help' );

/** Fetch terms once, preserve empty tabs, and order siblings consistently. */
function teamtakaros_gallery_tree() {
	$terms = get_terms( array( 'taxonomy' => 'tt_work_tab', 'hide_empty' => false ) );
	if ( is_wp_error( $terms ) ) {
		return array();
	}
	usort( $terms, function( $a, $b ) {
		$a_order = (int) get_term_meta( $a->term_id, '_tt_gallery_order', true );
		$b_order = (int) get_term_meta( $b->term_id, '_tt_gallery_order', true );
		if ( $a_order === $b_order ) {
			return $a->term_id - $b->term_id;
		}
		return $a_order - $b_order;
	} );
	$tree = array();
	foreach ( $terms as $term ) {
		if ( ! $term->parent ) {
			$tree[ $term->term_id ] = array( 'term' => $term, 'children' => array() );
		}
	}
	foreach ( $terms as $term ) {
		if ( isset( $tree[ $term->parent ] ) ) {
			$tree[ $term->parent ]['children'][] = $term;
		}
	}
	return $tree;
}

/** Fixed four-image pages, by upload date descending and ID for ties. */
function teamtakaros_gallery_page( $tab_id, $page = 1 ) {
	if ( ! teamtakaros_gallery_child( $tab_id ) ) {
		return new WP_Error( 'gallery_tab_missing', __( 'Αυτή η συλλογή δεν είναι διαθέσιμη.', 'teamtakaros' ), array( 'status' => 404 ) );
	}
	$files = get_term_meta( $tab_id, '_tt_gallery_photos', true );
	$ids = is_array( $files ) ? array_filter( array_map( 'absint', array_keys( $files ) ) ) : array();
	$result = array( 'html' => '', 'page' => (int) $page, 'total' => 0, 'hasMore' => false );
	if ( empty( $ids ) ) {
		return $result;
	}
	$query = new WP_Query( array(
		'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image',
		'post__in' => $ids, 'posts_per_page' => 4, 'paged' => max( 1, (int) $page ),
		'orderby' => array( 'date' => 'DESC', 'ID' => 'DESC' ),
		'ignore_sticky_posts' => true,
	) );
	ob_start();
	foreach ( $query->posts as $photo ) {
		$url = wp_get_attachment_image_url( $photo->ID, 'full' );
		$metadata = wp_get_attachment_metadata( $photo->ID );
		$is_portrait = ! empty( $metadata['width'] ) && ! empty( $metadata['height'] ) && $metadata['height'] > $metadata['width'];
		$alt = get_post_meta( $photo->ID, '_wp_attachment_image_alt', true );
		$caption = wp_strip_all_tags( wp_get_attachment_caption( $photo->ID ) );
		$description = $alt ? $alt : ( $caption ? $caption : $photo->post_title );
		?>
		<article class="project" data-photo-id="<?php echo esc_attr( $photo->ID ); ?>">
			<button type="button" class="project-image<?php echo $is_portrait ? ' is-portrait' : ''; ?>" data-photo="<?php echo esc_url( $url ); ?>" data-alt="<?php echo esc_attr( $description ); ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Μεγέθυνση: %s', 'teamtakaros' ), $description ) ); ?>">
				<?php echo wp_get_attachment_image( $photo->ID, 'large', false, array( 'alt' => $description, 'loading' => 'lazy', 'sizes' => '(max-width: 479px) 100vw, (max-width: 1199px) 50vw, 38vw' ) ); ?>
				<span aria-hidden="true">↗</span>
			</button>
		</article>
		<?php
	}
	$result['html'] = ob_get_clean();
	$result['total'] = (int) $query->found_posts;
	$result['hasMore'] = $page < (int) $query->max_num_pages;
	return $result;
}

/** Public read-only endpoint: the client cannot choose attachment IDs or page size. */
function teamtakaros_gallery_routes() {
	register_rest_route( 'teamtakaros/v1', '/gallery', array(
		'methods' => WP_REST_Server::READABLE,
		'permission_callback' => '__return_true',
		'callback' => function( $request ) {
			return rest_ensure_response( teamtakaros_gallery_page( $request['tab'], $request['page'] ) );
		},
		'args' => array(
			'tab' => array( 'required' => true, 'type' => 'integer', 'minimum' => 1 ),
			'page' => array( 'default' => 1, 'type' => 'integer', 'minimum' => 1, 'maximum' => 10000 ),
		),
	) );
}
add_action( 'rest_api_init', 'teamtakaros_gallery_routes' );

/** Offer a nonce-protected, idempotent migration on other installations. */
function teamtakaros_gallery_import_notice() {
	$screen = get_current_screen();
	if ( ! $screen || 'tt_work_tab' !== $screen->taxonomy || get_option( 'tt_gallery_imported' ) || ! current_user_can( 'manage_options' ) ) {
		return;
	}
	$url = wp_nonce_url( admin_url( 'admin-post.php?action=tt_import_gallery' ), 'tt_import_gallery' );
	echo '<div class="notice notice-info"><p>' . esc_html__( 'You can import the original theme gallery once. This adds the four existing parent tabs, one child collection per parent, and their photos.', 'teamtakaros' ) . ' <a href="' . esc_url( $url ) . '">' . esc_html__( 'Import original gallery', 'teamtakaros' ) . '</a></p></div>';
}
add_action( 'admin_notices', 'teamtakaros_gallery_import_notice' );

function teamtakaros_gallery_import_action() {
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_die( esc_html__( 'Administrator access is required.', 'teamtakaros' ), '', array( 'response' => 403 ) );
	}
	check_admin_referer( 'tt_import_gallery' );
	require_once get_template_directory() . '/inc/gallery-import.php';
	$result = teamtakaros_import_legacy_gallery();
	if ( is_wp_error( $result ) ) {
		wp_die( esc_html( $result->get_error_message() ) );
	}
	wp_safe_redirect( admin_url( 'edit-tags.php?taxonomy=tt_work_tab&post_type=attachment' ) );
	exit;
}
add_action( 'admin_post_tt_import_gallery', 'teamtakaros_gallery_import_action' );

/** Collections are managed on the tab editor, not the attachment taxonomy box. */
function teamtakaros_gallery_attachment_fields( $fields ) {
	unset( $fields['tt_work_tab'] );
	return $fields;
}
add_filter( 'attachment_fields_to_edit', 'teamtakaros_gallery_attachment_fields' );

/** Native taxonomy post counts do not represent the CMB2 photo collections. */
function teamtakaros_gallery_columns( $columns ) {
	unset( $columns['posts'] );
	$columns['tt_gallery_level'] = __( 'Level', 'teamtakaros' );
	$columns['tt_gallery_order'] = __( 'Order', 'teamtakaros' );
	return $columns;
}
add_filter( 'manage_edit-tt_work_tab_columns', 'teamtakaros_gallery_columns' );

function teamtakaros_gallery_column_value( $value, $column, $id ) {
	if ( 'tt_gallery_order' === $column ) {
		return (string) absint( get_term_meta( $id, '_tt_gallery_order', true ) );
	}
	if ( 'tt_gallery_level' === $column ) {
		return teamtakaros_gallery_child( $id ) ? esc_html__( 'Child collection', 'teamtakaros' ) : esc_html__( 'Parent tab', 'teamtakaros' );
	}
	return $value;
}
add_filter( 'manage_tt_work_tab_custom_column', 'teamtakaros_gallery_column_value', 10, 3 );
