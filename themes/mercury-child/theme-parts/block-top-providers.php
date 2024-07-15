<?php
$title       = $args['title'] ?? null;
$providers_ids = $args['providers'] ?? null;
?>

<section class="section-wrap">
	<div class="view-all-title">
		<h3><?php echo $title ?></h3>
	</div>

	<?php if ( is_array( $providers_ids ) ): ?>
		<div class="list-items-wrap">
			<?php foreach ( $providers_ids as $provider_id ): ?>
				<?php get_template_part( 'theme-parts/item-top-vendor', null, [ 'vendor_id' => $provider_id ] ); ?>
			<?php endforeach; ?>
		</div>
	<?php endif; ?>
</section>