<?php
$vendor_id = $args['vendor_id'] ?? null;
$term      = get_term_by( 'id', $vendor_id, 'vendor' );

if ( ! $term ) {
	return null;
}

$term_image_id = get_term_meta( $term->term_id, 'taxonomy-image-id', true );
?>

<div class="top-vendor-item-wrap" style="width: 100px">
	<a href="<?php echo esc_url( get_term_link( (int) $term->term_id, $term->taxonomy ) ); ?>">
		<?php if ( $term_image_id ): ?>
			<?php echo wp_get_attachment_image( $term_image_id, 'zlots-190-135' ); ?>
		<?php endif; ?>
	</a>
</div>
