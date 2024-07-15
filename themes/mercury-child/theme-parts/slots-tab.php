<?php
// Include CSS file for tabs styles
if (function_exists('wp_enqueue_style')) {
    wp_enqueue_style('tabs-styles', get_stylesheet_directory_uri() . '/css/tabs.css', array(), '1.0', 'all');
}

$slots_new_query = new WP_Query(array(
    'post_type' => 'game',
    'meta_query' => array(
        array(
            'key' => 'zlots_slots_show_in_tab',
            'value' => 'new',
            'compare' => '='
        )
    )
));

$slots_upcoming_query = new WP_Query(array(
    'post_type' => 'game',
    'meta_query' => array(
        array(
            'key' => 'zlots_slots_show_in_tab',
            'value' => 'upcoming',
            'compare' => '='
        )
    )
));

$slots_month_query = new WP_QUERY(array(
    'post_type' => 'game',
    'meta_query' => array(
        array(
            'key' => 'zlots_slots_show_in_tab',
            'value' => 'month',
            'compare' => '='
        )
    )
));
?>
<section class="section-wrap tabs-wrap">
    <ul class="tabs alignfull" style="background:linear-gradient(90deg,rgb(4,28,87) 0%,rgb(3,36,125) 100%);padding-top:30px;padding-bottom:30px;">
        <li class="tab-link current" data-tab="new">New Releases</li>
        <li class="tab-link" data-tab="upcoming">Upcoming Slots</li>
        <li class="tab-link" data-tab="month">Slots of the month</li>
    </ul>
    <div id="new" class="tab-content current">
        <div class="swiper-container slide-container">
            <div class="swiper-wrapper slide-content">
                <?php if ($slots_new_query->have_posts()): ?>
                    <?php while ($slots_new_query->have_posts()): $slots_new_query->the_post(); ?>
                        <div class="swiper-slide card">
                            <?php get_template_part('theme-parts/slot-item', null, ['slot_id' => get_the_ID()]); ?>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div id="upcoming" class="tab-content">
        <div class="swiper-container slide-container">
            <div class="swiper-wrapper slide-content">
                <?php if ($slots_upcoming_query->have_posts()): ?>
                    <?php while ($slots_upcoming_query->have_posts()): $slots_upcoming_query->the_post(); ?>
                        <div class="swiper-slide card">
                            <?php get_template_part('theme-parts/slot-item', null, ['slot_id' => get_the_ID()]); ?>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <div id="month" class="tab-content">
        <div class="swiper-container slide-container">
            <div class="swiper-wrapper slide-content">
                <?php if ($slots_month_query->have_posts()): ?>
                    <?php while ($slots_month_query->have_posts()): $slots_month_query->the_post(); ?>
                        <div class="swiper-slide card">
                            <?php get_template_part('theme-parts/slot-item', null, ['slot_id' => get_the_ID()]); ?>
                        </div>
                    <?php endwhile; ?>
                    <?php wp_reset_postdata(); ?>
                <?php endif; ?>
            </div>
            <!-- Add Arrows -->
            <div class="swiper-button-next swiper-navBtn"></div>
            <div class="swiper-button-prev swiper-navBtn"></div>
            <div class="swiper-pagination"></div>
        </div>
    </div>
</section>
