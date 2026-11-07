<?php
/** Dashboard-managed homepage audio playlist. @package teamtakaros */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/** Use the existing Hero options page and its capability/nonce checks. */
function teamtakaros_playlist_fields( $box ) {
	$group = $box->add_field( array(
		'id' => 'audio_tracks',
		'name' => __( 'Homepage audio playlist', 'teamtakaros' ),
		'type' => 'group',
		'description' => __( 'Add audio from the Media Library. Use the arrows to arrange playback order, then Save content. Edit track titles in Media. Removing every track hides the player.', 'teamtakaros' ),
		'options' => array(
			'group_title' => __( 'Track {#}', 'teamtakaros' ),
			'add_button' => __( 'Add track', 'teamtakaros' ),
			'remove_button' => __( 'Remove track', 'teamtakaros' ),
			'sortable' => true,
		),
	) );
	$box->add_group_field( $group, array(
		'id' => 'audio',
		'name' => __( 'Audio file', 'teamtakaros' ),
		'type' => 'file',
		'options' => array( 'url' => false ),
		'query_args' => array( 'type' => 'audio' ),
		'text' => array( 'add_upload_file_text' => __( 'Select or upload audio', 'teamtakaros' ) ),
	) );
}

/** Resolve saved attachment IDs; ignore URLs, missing files and non-audio media. */
function teamtakaros_playlist_ids() {
	$options = get_option( 'teamtakaros_content_hero', array() );
	$rows = isset( $options['audio_tracks'] ) && is_array( $options['audio_tracks'] ) ? $options['audio_tracks'] : array();
	$ids = array();
	foreach ( $rows as $row ) {
		$id = is_array( $row ) && isset( $row['audio_id'] ) && is_scalar( $row['audio_id'] ) ? absint( $row['audio_id'] ) : 0;
		// get_post_status() resolves attachment inheritance to "publish" or the
		// parent's status. Check the stored status, as the core playlist query does.
		if ( $id && 'attachment' === get_post_type( $id ) && 'inherit' === get_post_field( 'post_status', $id, 'raw' ) && wp_attachment_is( 'audio', $id ) && wp_get_attachment_url( $id ) ) {
			$ids[] = $id;
		}
	}
	return array_values( array_unique( $ids ) );
}

/** Load core player styles before the head is printed. */
function teamtakaros_playlist_assets() {
	if ( ! is_front_page() || ! teamtakaros_playlist_ids() ) {
		return;
	}
	wp_enqueue_style( 'wp-mediaelement' );
	wp_enqueue_script( 'wp-playlist' );
	wp_enqueue_style( 'teamtakaros-playlist', get_template_directory_uri() . '/assets/css/playlist.css', array( 'teamtakaros-main-styles', 'wp-mediaelement' ), filemtime( get_template_directory() . '/assets/css/playlist.css' ) );
}
add_action( 'wp_enqueue_scripts', 'teamtakaros_playlist_assets', 20 );
