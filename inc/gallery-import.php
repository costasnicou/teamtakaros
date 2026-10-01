<?php
/** One-time migration of the theme's existing gallery into WordPress media. @package teamtakaros */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function teamtakaros_import_legacy_gallery() {
	if ( ! current_user_can( 'manage_options' ) || ! current_user_can( 'upload_files' ) ) {
		return new WP_Error( 'gallery_import_forbidden', 'Administrator access is required.' );
	}
	if ( get_option( 'tt_gallery_imported' ) ) {
		return true;
	}
	require_once ABSPATH . 'wp-admin/includes/image.php';
	require_once ABSPATH . 'wp-admin/includes/file.php';
	$manifest = json_decode( file_get_contents( get_template_directory() . '/inc/gallery-legacy.json' ), true );
	if ( ! is_array( $manifest ) ) {
		return new WP_Error( 'gallery_manifest', 'Could not read the original gallery.' );
	}
	$groups = array(
		'Ηχοσυστήματα' => array( 'name' => 'Ηχοσυστήματα', 'slug' => 'car-audio' ),
		'Ταπετσαρίες' => array( 'name' => 'Ταπετσαρίες', 'slug' => 'custom-interiors' ),
		'Αυτοκίνητα' => array( 'name' => 'Αντηλιακές Μεμβράνες', 'slug' => 'window-films' ),
		'Awards' => array( 'name' => 'Διαγωνισμοί και Βραβεία', 'slug' => 'awards' ),
	);
	$collections = array();
	$order = 0;
	foreach ( $groups as $key => $group ) {
		$parent = term_exists( $group['slug'], 'tt_work_tab', 0 );
		if ( ! $parent ) {
			$parent = wp_insert_term( $group['name'], 'tt_work_tab', array( 'slug' => $group['slug'] ) );
		}
		if ( is_wp_error( $parent ) ) { return $parent; }
		$parent_id = (int) $parent['term_id'];
		update_term_meta( $parent_id, '_tt_gallery_order', $order++ );
		$child_slug = $group['slug'] . '-selected';
		$child = term_exists( $child_slug, 'tt_work_tab', $parent_id );
		if ( ! $child ) {
			$child = wp_insert_term( 'Επιλεγμένα έργα', 'tt_work_tab', array( 'slug' => $child_slug, 'parent' => $parent_id ) );
		}
		if ( is_wp_error( $child ) ) { return $child; }
		$collections[ $key ] = (int) $child['term_id'];
	}
	$base_time = current_time( 'timestamp' );
	foreach ( $manifest as $index => $item ) {
		$existing = get_posts( array(
			'post_type' => 'attachment', 'post_status' => 'inherit', 'posts_per_page' => 1,
			'meta_key' => '_tt_gallery_legacy_file', 'meta_value' => $item['file'], 'fields' => 'ids',
		) );
		$id = $existing ? $existing[0] : 0;
		if ( ! $id ) {
			$path = get_template_directory() . '/assets/imgs/' . basename( $item['file'] );
			if ( ! is_readable( $path ) ) {
				return new WP_Error( 'gallery_missing_image', 'Missing original image: ' . basename( $item['file'] ) );
			}
			$upload = wp_upload_bits( basename( $path ), null, file_get_contents( $path ) );
			if ( $upload['error'] ) { return new WP_Error( 'gallery_upload', $upload['error'] ); }
			$date = gmdate( 'Y-m-d H:i:s', $base_time - $index );
			$id = wp_insert_attachment( array(
				'post_title' => $item['alt'], 'post_excerpt' => $item['caption'],
				'post_mime_type' => wp_check_filetype( $upload['file'] )['type'],
				'post_status' => 'inherit', 'post_date' => $date, 'post_date_gmt' => get_gmt_from_date( $date ),
			), $upload['file'], 0, true );
			if ( is_wp_error( $id ) ) { return $id; }
			update_post_meta( $id, '_tt_gallery_legacy_file', $item['file'] );
			update_post_meta( $id, '_wp_attachment_image_alt', $item['alt'] );
			wp_update_attachment_metadata( $id, wp_generate_attachment_metadata( $id, $upload['file'] ) );
		}
		$term_id = $collections[ $item['category'] ];
		$photos = get_term_meta( $term_id, '_tt_gallery_photos', true );
		$photos = is_array( $photos ) ? $photos : array();
		$photos[ $id ] = wp_get_attachment_url( $id );
		update_term_meta( $term_id, '_tt_gallery_photos', $photos );
	}
	update_option( 'tt_gallery_imported', 1, false );
	return true;
}
