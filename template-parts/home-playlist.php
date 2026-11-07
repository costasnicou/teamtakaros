<?php
/** Homepage listening section. @package teamtakaros */
$track_ids = teamtakaros_playlist_ids();
if ( ! $track_ids ) {
	return;
}
?>
<section class="home-playlist" aria-labelledby="home-playlist-heading">
	<div class="wraper">
		<p id="home-playlist-heading" style="text-align:center;"><?php esc_html_e( 'Πάτησε play και άκου την playlist μας.', 'teamtakaros' ); ?></p>
	
		<?php
		// Core waits for Play, then advances automatically even with the track list hidden.
		echo wp_playlist_shortcode( array(
			'type' => 'audio',
			'ids' => implode( ',', $track_ids ),
			'orderby' => 'post__in',
			'images' => false,
			'artists' => false,
			'tracklist' => false,
		) );
		?>
	</div>
</section>
