<?php
/*
Template Name: Slots Archive Style Zlots
*/

$current_page_id = get_the_ID();

$terms_categories = get_terms( [ 'taxonomy' => 'game-category' ] );
?>
<?php get_header(); ?>

<!-- Title Box Start -->
<style>
	
	@media screen and (max-width: 767px) {
  .slots-content {
    display: flex;
    flex-direction: column;
    align-items: center;
  }
		#slots-archive-items{
			margin-top:15px !important;
		}
}
</style>
<div class="space-archive-title-box box-100 relative">
  <div class="space-archive-title-box-ins space-page-wrapper relative">
    <div class="space-archive-title-box-h1 relative">
      <h1><?php the_title(); ?></h1>
      <!-- Breadcrumbs Start -->
      <div class="space-breadcrumbs relative">
        <span>
          <span><a href="<?php echo home_url() ?>">Zlots.com</a></span> /
          <span class="breadcrumb_last" aria-current="page">Slots</span>
        </span>
      </div>
      <!-- Breadcrumbs End -->
    </div>
  </div>
</div>
<!-- Title Box End -->

<!-- Archive Section Start -->
<section class="recommended-casinos-wrap">
  <?php
  $page_loop = new WP_Query(
    array(
      'page_id' => $current_page_id
    )
  );

  if ($page_loop->have_posts()):
    while ($page_loop->have_posts()):
      $page_loop->the_post(); ?>
  <?php the_content(); ?>
  <?php endwhile;
    wp_reset_postdata();
  endif;
  ?>
</section>

<div class="space-archive-section box-100 relative space-organization-archive">
  <div class="space-archive-section-ins space-page-wrapper relative">
    <div class="space-organization-archive-ins box-100 relative">
      <section class="section-wrap slots-wrap">
        <div class="available-slots-title list-title">
          <h3>Available Slots</h3>
          <div>
            <form class="select-wrap">
              <?php if (is_array($terms_categories) && !empty($terms_categories)): ?>
				<div class="labelparent">
					<label class="label" for="sortBy">Sort by:</label>
              <div class="select-inner-wrap">
                <select name="casino-category" id="sort-by">
                  <?php foreach ($terms_categories as $term): ?>
                  <option value="<?php echo $term->slug ?>"><?php echo $term->name; ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
				</div>
              
              <?php endif; ?>
            </form>
          </div>
        </div>

        <div class="slots-content">
          <?php get_template_part('theme-parts/filter-archive-slots'); ?>
          <div id="slots-archive-items" class="box-100">
            <div class="list-items-wrap slots-archive-items-wrap">
              <?php
              $slots_list = zlots_get_slots_archive_query();
              $slots_html = zlots_get_slots_archive_html( $slots_list );
            ?>
              <?php echo $slots_html ?>
            </div>
			  <button id="load-more-slots" class="mainstylebutton" type="button">Load More</button>
			<!--
            <div id="load-more" class="load-more-wrap">
              <i class="load-more-icon"></i> Load More
            </div>
-->
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<!-- Archive Section End -->

<?php get_footer();
