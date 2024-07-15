<?php

$vendor_id = $args['vendor_id'] ?? null;
$term      = get_term_by( 'id', $vendor_id, 'vendor' );

if ( ! $term ) {
	return null;
}

$term_image_id = get_term_meta( $term->term_id, 'taxonomy-image-id', true );
$established   = get_term_meta( $term->term_id, 'zlots_taxonomy_established', true );
$slot_count = zlots_get_post_count_for_term( $term->slug );

?>

<div class="vendor-item-wrap" style="width: 100px">
    <div class="vendor-item-top">
		<?php if ( $term_image_id ): ?>
			<?php echo wp_get_attachment_image( $term_image_id, 'zlots-220-80' ); ?>
		<?php endif; ?>
    </div>

    <div class="vendor-item-middle">
	    <h4><?php echo $term->name ?></h4>
    </div>

    <div class="vendor-item-bottom">
        <div class="left">
            <p>Slots</p>
            <?php echo $slot_count; ?>
        </div>

        <div class="right">
            <p>Established</p>
            <?php echo $established ?>
        </div>
    </div>
    <a href="<?php echo esc_url( get_term_link( (int) $term->term_id, $term->taxonomy ) ); ?>">Review</a>
</div>
