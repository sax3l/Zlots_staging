<?php
// Include CSS file for slot item styles
if ( function_exists( 'wp_enqueue_style' ) ) {
    wp_enqueue_style( 'slot-item-styles', get_stylesheet_directory_uri() . '/css/item-slot.css', array(), '1.0', 'all' );
}

$slot_id = $args['slot_id'] ?? null;

$game_rating = esc_html( get_post_meta( $slot_id, 'game_rating_one', true ) );

if ( get_option( 'aces_game_rating_stars_number' ) ) {
    $game_rating_stars_number_value = get_option( 'aces_game_rating_stars_number' );
} else {
    $game_rating_stars_number_value = '5';
}

$primary_category_id = get_post_meta( $slot_id, '_yoast_wpseo_primary_game-category', true );

// Get primary term
$primary_term = ! empty( $primary_category_id ) ? get_term( $primary_category_id ) : null;

// Get terms
$terms = get_the_terms( $slot_id, 'game-category' );

?>
<div class="slot-item-wrap">
    <?php if ( $primary_term && ! is_wp_error( $primary_term ) ): ?>
        <div class="tag-item slot-item-tag">
            <a href="<?php echo esc_url( get_term_link( (int) $primary_term->term_id, $primary_term->taxonomy ) ); ?>">
                <?php echo esc_html( $primary_term->name ); ?>
            </a>
        </div>
    <?php else : ?>
        <?php if ( ! empty( $terms ) && ! is_wp_error( $terms ) && isset( $terms[0] ) ): ?>
            <div class="tag-item slot-item-tag">
                <a href="<?php echo esc_url( get_term_link( (int) $terms[0]->term_id, $terms[0]->taxonomy ) ); ?>">
                    <?php echo esc_html( $terms[0]->name ); ?>
                </a>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="rating slot-item-rating">
        <i class="fas fa-star"></i>
        <strong><?php echo esc_html( number_format( round( $game_rating, 1 ), 1, '.', ',' ) ); ?></strong>&emsp;/ <?php echo esc_html( $game_rating_stars_number_value ); ?>
    </div>
    <div class="slot-item-image">
        <?php echo wp_get_attachment_image( get_post_thumbnail_id( $slot_id ), 'mercury-270-270' ); ?>
    </div>
    <a class="link-button red-link-button slot-item-play" href="<?php echo esc_url( get_permalink( $slot_id ) ); ?>">Play Now</a>
</div>
