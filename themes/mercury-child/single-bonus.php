<?php
get_header();

use Zlots\Casinos\Bonus;

$post_id = get_the_ID();

$bonus = new Bonus( $post_id );
?>

<div id="post-<?php the_ID(); ?>">
  <div class="single-page-wrap">

    <!-- Title Box Start -->
    <div class="box-100 relative">
      <div class="space-archive-title-box-ins space-page-wrapper relative">
        <!-- Breadcrumbs Start -->
        <div class="space-breadcrumbs relative">
          <span><a href="<?php echo home_url() ?>">Home</a></span> /
          <span><a href="<?php echo home_url( 'bonuses' ) ?>">Bonuses</a></span> /</span>
          <span class="breadcrumb_last" aria-current="page"><?php echo get_the_title() ?></span>
        </div>
        <!-- Breadcrumbs End -->
      </div>
    </div>
    <!-- Title Box End -->

    <div class="space-page-wrapper single-bonus-content-wrap">
      <div class="single-bonus-top-info-wrap">
        <div class="left-side-wrap">
          <div class="logo-wrap">
            <?php if ( is_array( $bonus->get_categories() ) && ! empty( $bonus->get_categories() ) ): ?>
            <div class="tag-item casino-tag">
              <?php foreach ( $bonus->get_categories() as $item ): ?>
              <a
                href="<?php echo esc_url( get_term_link( (int) $item->term_id, $item->taxonomy ) ); ?>"><?php echo $item->name ?></a>
              <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="tag-item casino-tag"><a href="">No tag</a></div>
            <?php endif; ?>
            <?php echo $bonus->get_image( 'zlots-300-300' ) ?>
          </div>
        </div>

        <div class="right-side-wrap">
          <div class="title-wrap">
            <h1><?php the_title(); ?></h1>

            <div class="code bonus-code">
              <?php esc_html_e( 'Bonus Code', 'zlots' ); ?>:
              <?php echo $bonus->get_code(); ?>
            </div>
          </div>

          <div class="date-excerpt-wrap vertical-centered">
            <div class="date vertical-centered">
              <i class="fa fa-calendar-alt vertical-horizontal-centered"></i>
              <p><?php esc_html_e( 'Valid until', 'zlots' ); ?>:
                <?php echo $bonus->get_valid_date(); ?></p>
            </div>

            <div class="excerpt">
              <p><?php echo $bonus->get_excerpt(); ?></p>
            </div>
          </div>

          <?php get_template_part('theme-parts/block-bonus-indicators', null, [ 
							'wager' =>$bonus->get_wager(),
							'spins' => $bonus->get_spins(),
							'amount' => $bonus->get_amount(),
							'percentage' => $bonus->get_percentage(),
							] 
						);
					?>

          
        </div>
      </div>

      <section class="single-casino-middle-info-wrap section-wrap">
        <div class="left-side-wrap">
          <section class="tabs-wrap section-wrap">
            
       

          <section class="rating-wrap section-wrap">
            <h3>Rating</h3>
            <div class="space-organization-style-2-calltoaction-rating relative">
              <div class="space-organization-style-2-calltoaction-rating-ins box-100 relative">
                <div class="space-organization-style-2-calltoaction-block box-100 relative">
                  <div class="space-organization-style-2-calltoaction-text box-66 relative">

                    <?php if ($casino_terms_desc) : ?>
                    <div class="space-organization-style-2-calltoaction-text-ins relative">
                      <?php echo wp_kses( $casino_terms_desc, $casino_allowed_html ); ?>
                    </div>
                    <?php endif; ?>

                  </div>
                </div>

                <div class="space-organization-style-2-ratings-block box-100 relative">
                  <div class="space-organization-style-2-ratings-all box-66 relative">
                    <div class="space-organization-style-2-ratings-all-ins box-100 relative">

                      <?php if ( $casino_rating_trust ) : ?>
                      <div class="space-organization-style-2-ratings-all-item box-50 relative">
                        <div class="space-organization-style-2-ratings-all-item-ins relative">
                          <div class="space-organization-style-2-ratings-all-item-value relative">
                            <?php echo esc_html( number_format( (float) $casino_rating_trust, 1, '.', ',' ) ); ?>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_1_title = get_option( 'rating_1' );
                        if ( $rating_1_title ) {
                          echo esc_html( $rating_1_title );
                        } else {
                          esc_html_e( 'Trust & Fairness', 'mercury' );
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                      <?php if ( $casino_rating_games ) : ?>
                      <div class="space-organization-style-2-ratings-all-item box-50 relative">
                        <div class="space-organization-style-2-ratings-all-item-ins relative">
                          <div class="space-organization-style-2-ratings-all-item-value relative">
                            <?php echo esc_html( number_format( (float) $casino_rating_games, 1, '.', ',' ) ); ?>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_2_title = get_option( 'rating_2' );
                        if ( $rating_2_title ) {
                          echo esc_html( $rating_2_title );
                        } else {
                          esc_html_e( 'Games & Software', 'mercury' );
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                      <?php if ( $casino_rating_bonus ) : ?>
                      <div class="space-organization-style-2-ratings-all-item box-50 relative">
                        <div class="space-organization-style-2-ratings-all-item-ins relative">
                          <div class="space-organization-style-2-ratings-all-item-value relative">
                            <?php echo esc_html( number_format( (float) $casino_rating_bonus, 1, '.', ',' ) ); ?>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_3_title = get_option( 'rating_3' );
                        if ( $rating_3_title ) {
                          echo esc_html( $rating_3_title );
                        } else {
                          esc_html_e( 'Bonuses & Promotions', 'mercury' );
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                      <?php if ( $casino_rating_customer ) : ?>
                      <div class="space-organization-style-2-ratings-all-item box-50 relative">
                        <div class="space-organization-style-2-ratings-all-item-ins relative">
                          <div class="space-organization-style-2-ratings-all-item-value relative">
                            <?php echo esc_html( number_format( (float) $casino_rating_customer, 1, '.', ',' ) ); ?>
                            <i class="fas fa-star"></i>
                          </div>
                          <?php
                        $rating_4_title = get_option( 'rating_4' );
                        if ( $rating_4_title ) {
                          echo esc_html( $rating_4_title );
                        } else {
                          esc_html_e( 'Customer Support', 'mercury' );
                        } 
                      ?>
                        </div>
                      </div>
                      <?php endif; ?>

                    </div>
                  </div>
                  <div class="space-organization-style-2-rating-overall box-33 relative">
                    <div class="space-organization-style-2-rating-overall-ins text-center relative">
                      <?php echo esc_html( number_format( (float) $casino_overall_rating, 1, '.', ',' ) ); ?>
                      <span>
                        <?php
                      $rating_overall_title = get_option( 'rating_overall' );
                      if ( $rating_overall_title ) {
                        echo esc_html( $rating_overall_title );
                      } else {
                        esc_html_e( 'Overall Rating', 'mercury' );
                      } 
                    ?>
                      </span>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
        </div>
        <div class="right-side-wrap blocks-wrap desktop-right-side-values">
          <?php get_template_part('theme-parts/item-hot-bonus-desktop'); ?>
        </div>
        <div class="right-side-wrap blocks-wrap mobile-right-side-values">
          <?php get_template_part('theme-parts/item-hot-bonus-mobile'); ?>
        </div>
      </section>

      <?php if ( is_array( $bonus->get_casinos() ) && ! empty( $bonus->get_casinos() ) ): ?>
      <section class="section-wrap top-rated-casinos-wrap">
        <h3>Parent casinos</h3>
        <div class="list-items-wrap casinos-items">
          <?php foreach ( $bonus->get_casinos() as $casino_id ): ?>
          <?php get_template_part( 'theme-parts/item-archive-casino', null, [ 'casino_id' => $casino_id ] ); ?>
          <?php endforeach; ?>
        </div>

      </section>
      <?php endif; ?>

      <div class="content-block">
        <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

        <?php the_content(); ?>

        <?php endwhile; endif; ?>
      </div>
    </div>
  </div>

</div>
</div>

<?php get_footer();