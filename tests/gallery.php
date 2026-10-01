<?php
/** Run: php tests/gallery.php /absolute/path/to/wp-load.php
 * Integration checks use temporary terms and existing media; no images are deleted.
 */
if ( PHP_SAPI !== 'cli' ) { exit; }
if ( empty( $argv[1] ) || ! is_file( $argv[1] ) ) {
	fwrite( STDERR, "Usage: php tests/gallery.php /path/to/wp-load.php\n" ); exit( 1 );
}
define( 'WP_ADMIN', true );
$_SERVER['SERVER_NAME'] = 'localhost';
require $argv[1];
function tt_check( $condition, $message ) {
	if ( ! $condition ) { throw new RuntimeException( $message ); }
	echo "PASS: $message\n";
}
function tt_term( $name, $parent = 0 ) {
	$term = wp_insert_term( $name, 'tt_work_tab', array( 'parent' => $parent ) );
	if ( is_wp_error( $term ) ) { throw new RuntimeException( $term->get_error_message() ); }
	return (int) $term['term_id'];
}
function tt_ids( $page ) {
	preg_match_all( '/data-photo-id="(\d+)"/', $page['html'], $matches );
	return array_map( 'intval', $matches[1] );
}
$roots = array();
$original_post = $_POST;
try {
	$admins = get_users( array( 'role' => 'administrator', 'number' => 1, 'fields' => 'ID' ) );
	wp_set_current_user( $admins[0] );
	$root = tt_term( 'Gallery test ' . uniqid() ); $roots[] = $root;
	$other_root = tt_term( 'Gallery test other ' . uniqid() ); $roots[] = $other_root;
	$child = tt_term( 'Collection A', $root );
	$second = tt_term( 'Collection B', $root );
	$empty = tt_term( 'Empty collection', $other_root );
	tt_check( teamtakaros_gallery_child( $child ) && ! teamtakaros_gallery_child( $root ), 'Only second-level tabs accept photo requests' );
	tt_check( is_wp_error( wp_insert_term( 'Invalid third level', 'tt_work_tab', array( 'parent' => $child ) ) ), 'Third level rejected on create' );
	wp_update_term( $second, 'tt_work_tab', array( 'parent' => $child ) );
	tt_check( (int) get_term( $second )->parent === $root, 'Third level rejected on edit' );
	wp_update_term( $root, 'tt_work_tab', array( 'parent' => $other_root ) );
	tt_check( 0 === (int) get_term( $root )->parent, 'Parent with children cannot become a child' );
	wp_update_term( $second, 'tt_work_tab', array( 'name' => 'Renamed collection', 'parent' => $other_root ) );
	tt_check( (int) get_term( $second )->parent === $other_root && 'Renamed collection' === get_term( $second )->name, 'Child tabs can be renamed and moved to another parent' );
	$images = get_posts( array( 'post_type' => 'attachment', 'post_status' => 'inherit', 'post_mime_type' => 'image', 'posts_per_page' => 10, 'orderby' => array( 'date' => 'DESC', 'ID' => 'DESC' ) ) );
	tt_check( count( $images ) >= 10, 'At least ten existing images available for pagination fixtures' );
	$ids = wp_list_pluck( $images, 'ID' );
	$files = array();
	foreach ( array_reverse( array_slice( $ids, 0, 9 ) ) as $id ) { $files[ $id ] = 'https://untrusted.invalid/image.jpg'; }
	$files[999999999] = 'https://untrusted.invalid/not-an-attachment.jpg';
	$box = CMB2_Boxes::get( 'tt_gallery_tab_fields' );
	$_POST = array( '_tt_gallery_order' => 3, '_tt_gallery_photos' => $files, $box->nonce() => wp_create_nonce( $box->nonce() ) );
	wp_update_term( $child, 'tt_work_tab', array( 'description' => 'Integration fixture' ) );
	$_POST = $original_post;
	$saved = get_term_meta( $child, '_tt_gallery_photos', true );
	tt_check( is_array( $saved ) && count( $saved ) === 9 && $saved[ $ids[0] ] === wp_get_attachment_url( $ids[0] ), 'CMB2 stores only real image IDs and canonical URLs' );
	update_term_meta( $second, '_tt_gallery_photos', array( $ids[9] => wp_get_attachment_url( $ids[9] ) ) );
	$one = teamtakaros_gallery_page( $child, 1 );
	$two = teamtakaros_gallery_page( $child, 2 );
	$three = teamtakaros_gallery_page( $child, 3 );
	tt_check( tt_ids( $one ) === array_slice( $ids, 0, 4 ) && $one['hasMore'], 'First page is exactly four newest photos, independent of uploader order' );
	tt_check( tt_ids( $two ) === array_slice( $ids, 4, 4 ) && $two['hasMore'], 'Second page contains only the next four photos' );
	tt_check( tt_ids( $three ) === array_slice( $ids, 8, 1 ) && ! $three['hasMore'], 'Final partial page hides Load more' );
	tt_check( tt_ids( teamtakaros_gallery_page( $second ) ) === array( $ids[9] ), 'Another tab has an isolated photo collection' );
	tt_check( tt_ids( teamtakaros_gallery_page( $child, 1 ) ) === tt_ids( $one ), 'Returning to page one resets to the initial four' );
	tt_check( 0 === teamtakaros_gallery_page( $empty )['total'], 'Empty collections return zero images, not the entire library' );
	$visible_field = $box->get_field( '_tt_gallery_photos' );
	tt_check( teamtakaros_gallery_photo_field_visible( $visible_field ), 'Photo uploader visible for child term' );
	$box->object_id( $root );
	$root_field = $box->get_field( '_tt_gallery_photos', null, true );
	tt_check( ! teamtakaros_gallery_photo_field_visible( $root_field ), 'Photo uploader hidden on parent terms' );
	wp_set_current_user( 0 );
	$request = new WP_REST_Request( 'GET', '/teamtakaros/v1/gallery' );
	$request->set_param( 'tab', $child );
	$request->set_param( 'page', 2 );
	$response = rest_do_request( $request );
	tt_check( 200 === $response->get_status() && tt_ids( $response->get_data() ) === tt_ids( $two ), 'Anonymous REST pagination returns selected-tab photos' );
	$request->set_param( 'page', 0 );
	tt_check( 400 === rest_do_request( $request )->get_status(), 'REST rejects invalid page numbers' );
	$request->set_param( 'page', 1 ); $request->set_param( 'tab', $root );
	tt_check( 404 === rest_do_request( $request )->get_status(), 'REST rejects parent tab photo requests' );
	unset( $saved[ $ids[0] ] ); update_term_meta( $child, '_tt_gallery_photos', $saved );
	tt_check( 8 === teamtakaros_gallery_page( $child )['total'], 'Removing a photo updates the collection immediately' );
	wp_delete_term( $child, 'tt_work_tab' );
	$request->set_param( 'tab', $child );
	tt_check( 404 === rest_do_request( $request )->get_status(), 'Deleted tabs no longer return photos' );
	wp_delete_term( $other_root, 'tt_work_tab' );
	tt_check( ! term_exists( $second, 'tt_work_tab' ) && ! term_exists( $empty, 'tt_work_tab' ), 'Deleting parent removes child tabs' );
	tt_check( (bool) get_post( $ids[9] ), 'Deleting tabs preserves Media Library images' );
	echo "All gallery integration checks passed.\n";
} finally {
	$_POST = $original_post;
	foreach ( $roots as $id ) { wp_delete_term( $id, 'tt_work_tab' ); }
}
