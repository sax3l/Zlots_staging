<?php
/*
Template Name: Providers Archive Style Zlots
*/
$current_page_id = get_the_ID();
get_header(); ?>

	<!-- Title Box Start -->
	<div class="space-archive-title-box box-100 relative">
		<div class="space-archive-title-box-ins space-page-wrapper relative">
			<div class="space-archive-title-box-h1 relative">
				<!-- Breadcrumbs Start -->
				<div class="space-single-aces-breadcrumbs relative">
					<div class="breadcrumbs">
						<ul>
							<li><a href="<?php echo home_url() ?>">Zlots.com</a> /</li>
							<li><p>Providers</p></li>
						</ul>
					</div>
				</div>
				<!-- Breadcrumbs End -->

				<h1><?php the_title(); ?></h1>
			</div>
		</div>
	</div>
	<!-- Title Box End -->

	<div class="space-archive-section box-100 relative space-organization-archive">
		<?php
		$page_loop = new WP_Query( array(
			'page_id' => $current_page_id
		) );

		if ( $page_loop->have_posts() ) :
			while ( $page_loop->have_posts() ) : $page_loop->the_post(); ?>

				<div class="space-taxonomy-description box-100 relative" style="margin-top: 45px;">
					<div class="space-page-content case-15 relative">

						<?php the_content(); ?>

					</div>
				</div>

			<?php endwhile;
			wp_reset_postdata();
		endif;
		?>
	</div>

	<div>
		<h2>Software Providers</h2>

		<input type="text" placeholder="Search Providers">
		<div>Sort by
			<select name="sort-by">
				<option value="top-rated">Top Rated</option>
			</select>
		</div>
		<div>
			<h2>Filters</h2>
			<form action="">
				Slots Amount
			</form>
		</div>

		<div class="casinos-list">
			<?php
			$vendor_list = zlots_get_vendor_archive_query();
			$vendor_html = zlots_get_vendor_archive_html( $vendor_list );
			?>
			<?php echo $vendor_html ?>
		</div>

		<div>
			<a href="#">Load More</a>
		</div>
	</div>

<?php get_footer();
