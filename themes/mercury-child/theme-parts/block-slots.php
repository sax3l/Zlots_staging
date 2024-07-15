<?php
$title     = $args['title'] ?? null;
$slots_ids = $args['slots'] ?? null;

$link_all_slots = home_url( 'slots' );
?>

<section class="section-wrap top-rated-casinos-wrap">
    <div class="view-all-title top-rated-casinos-title">
        <h3><?php echo $title ?></h3>
        <a href="<?php echo $link_all_slots ?>">
            View All <i class="fas fa-arrow-right"></i>
        </a>
    </div>

	<?php if ( is_array( $slots_ids ) ): ?>
        <div class="list-items-wrap top-rated-casinos-items">
			<?php foreach ( $slots_ids as $slot_id ): ?>
				<?php get_template_part( 'theme-parts/slot-item', null, [ 'slot_id' => $slot_id ] ); ?>
			<?php endforeach; ?>
        </div>
	<?php endif; ?>
</section>