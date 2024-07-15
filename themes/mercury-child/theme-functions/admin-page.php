<?php

function zlots_admin_side(){
	add_menu_page(
		esc_html__('Zlots Shortcodes', 'mercury'),
		esc_html__('Zlots Shortcodes', 'mercury'),
		'manage_options',
		'zlots_admin_page',
		'zlots_admin_page',
		'dashicons-awards',
		64
	);
}
add_action( 'admin_menu', 'zlots_admin_side' );

function zlots_admin_page() {
	?>

	<div class="wrap">
		<h1><?php esc_html_e('Mercury Theme', 'mercury'); ?> <?php esc_html_e($GLOBALS['mercury_version'], 'mercury'); ?></h1>
		<div class="card">
			<p>[zlots-search-form]</p>
		</div>
		<div class="card">
			<p>[zlots-slots-banner slot-id=""]</p>
		</div>
		<div class="card">
			<p>[zlots-recommended-casinos-block]</p>
		</div>
		<div class="card">
			<p>[zlots-slots-tab]</p>
		</div>
		<div class="card">
			<p>[zlots-top-rated-casinos title=""]</p>
		</div>
		<div class="card">
			<p>[zlots-show-news]</p>
		</div>


		<div class="card">
			<p>[zlots-]</p>
		</div>

	</div>
	<?php
}