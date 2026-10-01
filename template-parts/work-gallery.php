<?php
/** Two-level gallery controls and initial server-rendered photos. @package teamtakaros */
$gallery_tree = teamtakaros_gallery_tree();
?>
<div class="work-gallery" data-work-gallery data-endpoint="<?php echo esc_url( rest_url( 'teamtakaros/v1/gallery' ) ); ?>">
	<?php if ( empty( $gallery_tree ) ) : ?>
		<p class="gallery-empty"><?php esc_html_e( 'Νέες φωτογραφίες έρχονται σύντομα.', 'teamtakaros' ); ?></p>
	<?php else : ?>
		<div class="filters gallery-parents" role="tablist" aria-label="Κατηγορίες έργων">
			<?php $parent_index = 0; foreach ( $gallery_tree as $parent_id => $group ) : ?>
				<button type="button" role="tab" id="gallery-parent-<?php echo esc_attr( $parent_id ); ?>" aria-controls="gallery-group-<?php echo esc_attr( $parent_id ); ?>" aria-selected="<?php echo 0 === $parent_index ? 'true' : 'false'; ?>" tabindex="<?php echo 0 === $parent_index ? '0' : '-1'; ?>" data-gallery-parent="<?php echo esc_attr( $parent_id ); ?>"><?php echo esc_html( $group['term']->name ); ?></button>
			<?php ++$parent_index; endforeach; ?>
		</div>
		<?php $parent_index = 0; foreach ( $gallery_tree as $parent_id => $group ) : ?>
			<div id="gallery-group-<?php echo esc_attr( $parent_id ); ?>" role="tabpanel" aria-labelledby="gallery-parent-<?php echo esc_attr( $parent_id ); ?>" data-gallery-group="<?php echo esc_attr( $parent_id ); ?>" <?php echo $parent_index ? 'hidden' : ''; ?>>
				<?php if ( empty( $group['children'] ) ) : ?>
					<p class="gallery-empty"><?php esc_html_e( 'Νέες συλλογές έρχονται σύντομα.', 'teamtakaros' ); ?></p>
				<?php else : ?>
					<div class="gallery-children" role="tablist" aria-label="<?php echo esc_attr( sprintf( __( 'Συλλογές: %s', 'teamtakaros' ), $group['term']->name ) ); ?>">
						<?php foreach ( $group['children'] as $child_index => $child ) : ?>
							<button type="button" role="tab" id="gallery-tab-<?php echo esc_attr( $child->term_id ); ?>" aria-controls="gallery-collection-<?php echo esc_attr( $child->term_id ); ?>" aria-selected="<?php echo 0 === $child_index ? 'true' : 'false'; ?>" tabindex="<?php echo 0 === $child_index ? '0' : '-1'; ?>" data-gallery-child="<?php echo esc_attr( $child->term_id ); ?>"><?php echo esc_html( $child->name ); ?></button>
						<?php endforeach; ?>
					</div>
					<?php foreach ( $group['children'] as $child_index => $child ) :
						$is_initial = 0 === $parent_index && 0 === $child_index;
						$photos = $is_initial ? teamtakaros_gallery_page( $child->term_id ) : array( 'html' => '', 'total' => 0, 'hasMore' => false );
						?>
						<div class="gallery-collection" id="gallery-collection-<?php echo esc_attr( $child->term_id ); ?>" role="tabpanel" aria-labelledby="gallery-tab-<?php echo esc_attr( $child->term_id ); ?>" tabindex="0" data-gallery-collection="<?php echo esc_attr( $child->term_id ); ?>" data-page="1" data-total="<?php echo esc_attr( $photos['total'] ); ?>" <?php echo $child_index ? 'hidden' : ''; ?>>
							<?php if ( $child->description ) : ?><p class="gallery-description"><?php echo esc_html( $child->description ); ?></p><?php endif; ?>
							<div class="project-grid" id="gallery-grid-<?php echo esc_attr( $child->term_id ); ?>"><?php echo $photos['html']; // Escaped by teamtakaros_gallery_page(). ?></div>
							<p class="gallery-status" role="status" aria-live="polite" aria-atomic="true"><?php
								if ( $is_initial ) {
									echo $photos['total'] ? esc_html( sprintf( __( '%1$d από %2$d φωτογραφίες', 'teamtakaros' ), min( 4, $photos['total'] ), $photos['total'] ) ) : esc_html__( 'Δεν υπάρχουν ακόμα φωτογραφίες σε αυτή τη συλλογή.', 'teamtakaros' );
								}
							?></p>
							<div class="gallery-actions"><button type="button" class="gallery-load-more" aria-controls="gallery-grid-<?php echo esc_attr( $child->term_id ); ?>" <?php echo $photos['hasMore'] ? '' : 'hidden'; ?>>Περισσότερες φωτογραφίες <span aria-hidden="true">+</span></button></div>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		<?php ++$parent_index; endforeach; ?>
		<noscript><p>Ενεργοποιήστε τη JavaScript για να αλλάξετε συλλογή και να δείτε περισσότερες φωτογραφίες.</p></noscript>
	<?php endif; ?>
	<dialog id="photo-dialog" aria-label="Προβολή έργου">
		<button type="button" class="close" aria-label="Κλείσιμο φωτογραφίας">×</button>
		<img alt="" />
			
	</dialog>
</div>
