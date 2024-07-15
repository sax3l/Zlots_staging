<?php
/*
Template Name: Bonuses Archive Style Zlots
*/

$current_page_id = get_the_ID();

$terms_categories = get_terms( [ 'taxonomy' => 'bonus-category' ] );

?>
<?php get_header(); ?>

<!-- Title Box Start -->
<div class="space-archive-title-box box-100 relative">
  <div class="space-archive-title-box-ins space-page-wrapper relative">
    <div class="space-archive-title-box-h1 relative">
      <h1><?php the_title(); ?></h1>
      <!-- Breadcrumbs Start -->
      <div class="space-breadcrumbs relative">
        <span>
          <span><a href="<?php echo home_url() ?>"><?php esc_html_e('Zlots.com', 'zlots') ?></a></span> /
          <span class="breadcrumb_last" aria-current="page"><?php esc_html_e('Bonuses', 'zlots') ?></span>
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
      $page_loop = new WP_Query( array(
        'page_id' => $current_page_id
      ) );

      if ( $page_loop->have_posts() ) :
        while ( $page_loop->have_posts() ) : $page_loop->the_post(); ?>

  <div class="space-taxonomy-description box-100 relative">
    <div class="space-page-content case-15 relative">

      <?php the_content(); ?>

    </div>
  </div>

  <?php endwhile;
      wp_reset_postdata();
    endif;
  ?>
</section>

<div class="space-archive-section box-100 relative space-organization-archive">
  <div class="space-archive-section-ins space-page-wrapper relative">
    <div class="space-organization-archive-ins box-100 relative">
      <section class="section-wrap bonuses-wrap">
        <div class="available-bonuses-title list-title">
          <h3>Available Bonuses</h3>
          <form class="select-wrap">
            <?php if (is_array($terms_categories) && !empty($terms_categories)): ?>
            <label class="label" for="sortBy">Sort by:</label>
            <div class="select-inner-wrap">
              <select name="casino-category" id="sort-by">
                <?php foreach ($terms_categories as $term): ?>
                <option value="<?php echo $term->slug ?>"><?php echo $term->name; ?></option>
                <?php endforeach; ?>
              </select>
            </div>
            <?php endif; ?>
            <?php get_template_part('theme-parts/mobile-menu-button'); ?>
          </form>
        </div>


        <div class="bonuses-content">
          <?php get_template_part('theme-parts/filter-archive-bonuses'); ?>

          <div id="bonuses-archive-items" class="box-100">
            <div class="list-items-wrap bonuses-archive-items-wrap">
              <?php
                  $bonuses_list = zlots_get_bonuses_archive_query();
                  $bonuses_html = zlots_get_bonuses_archive_html( $bonuses_list );
                ?>

              <?php echo $bonuses_html ?>
            </div>


            <div id="load-more" class="load-more-wrap">
              <i class="load-more-icon"></i> Load More
            </div>
          </div>
      
    </div>
		  </section>
  </div>
</div>
<!-- Archive Section End -->

<?php get_footer();