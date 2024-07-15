<?php
/*
Template Name: Casinos Archive Style Zlots
*/

$current_page_id = get_the_ID();

$terms_categories = get_terms(['taxonomy' => 'casino-category']);
?>

<?php get_header(); ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>

<!-- Title Box Start -->
<style>
    @media screen and (max-width: 767px) {
        .avalilable-casinos-content {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        #available-casinos-items {
            margin-top: 15px !important;
        }
    }
    .filter-toggle-button {
        display: none;
    }
    @media screen and (max-width: 767px) {
        .filter-toggle-button {
            display: block;
            cursor: pointer;
        }
        .filter-toggle-button {
            border: 3px solid var(--primary-green);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 10px 15px;
            width: 80%;
            font-size: 16px;
            font-weight: bolder;
            border-radius: 5px;
            text-decoration: none;
            cursor: pointer;
            color: var(--white);
            white-space: nowrap;
            background-color: var(--primary-green);
        }
        .filter-toggle {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.5s ease-out;
        }
    }
    @media screen and (min-width: 768px) {
        .filter-toggle {
            display: block;
            max-height: none;
        }
    }
</style>

<div class="space-archive-title-box box-100 relative">
    <div class="space-archive-title-box-ins space-page-wrapper relative">
        <div class="space-archive-title-box-h1 relative">
            <h1><?php the_title(); ?></h1>
            <div class="space-breadcrumbs relative">
                <span>
                    <span><a href="<?php echo home_url() ?>">Zlots.com</a></span> /
                    <span class="breadcrumb_last" aria-current="page">Casinos</span>
                </span>
            </div>
        </div>
    </div>
</div>

<section class="recommended-casinos-wrap">
    <?php
    $page_loop = new WP_Query(array(
        'page_id' => $current_page_id
    ));
    if ($page_loop->have_posts()):
        while ($page_loop->have_posts()):
            $page_loop->the_post();
            the_content();
        endwhile;
        wp_reset_postdata();
    endif;
    ?>
</section>

<div class="space-archive-section box-100 relative space-organization-archive">
    <div class="space-archive-section-ins space-page-wrapper relative">
        <div class="space-organization-archive-ins box-100 relative">
            <div class="section-wrap available-casinos-wrap">
                <div class="available-casinos-title list-title relative">
                    <h3>Available Casinos</h3>
                    <div>
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
                </div>

                <button id="filter-toggle-button" class="filter-toggle-button mobile-visible" onclick="toggleFilter()">Filters</button>
                <div class="filter-toggle" id="filter-toggle">
                    <?php get_template_part('theme-parts/filter-archive-casinos'); ?>
                </div>

                <div class="avalilable-casinos-content">
                    <div id="available-casinos-items" class="box-100">
                        <div class="list-items-wrap available-casinos-items-wrap">
                            <?php
                            $casinos_list = zlots_get_casinos_archive_query();
                            foreach ($casinos_list as $casino_id) {
                                get_template_part('theme-parts/item-archive-casino', null, ['casino_id' => $casino_id]);
                            }
                            ?>
                        </div>
                        <button id="load-more-casinos" class="mainstylebutton" type="button">Load More</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function toggleFilter() {
        var filterToggle = document.getElementById('filter-toggle');
        if (filterToggle.style.maxHeight) {
            filterToggle.style.maxHeight = null;
        } else {
            filterToggle.style.maxHeight = filterToggle.scrollHeight + "px";
        }
    }

    jQuery(document).ready(function ($) {
        'use strict';

        let offset = 18;
        let sliderPayload = {};
        let filtersPayload = null;

        function showLoadingOverlay() {
            $('.loading-overlay').css('display', 'flex');
        }

        function hideLoadingOverlay() {
            $('.loading-overlay').css('display', 'none');
        }

        function getCurrentFilters() {
            let filters = {
                'casino-category': [],
                'vendor': [],
                'deposit-method': [],
                'withdrawal-method': [],
                'withdrawal-limit': [],
                'restricted-country': [],
                'licence': [],
                'casino-language': [],
                'currency': [],
                'device': [],
                'owner': [],
                'casino-est': []
            };

            $('#available-casinos-filters .accordion-wrap input:checked').each(function () {
                let filterType = $(this).attr('name');
                filters[filterType].push($(this).val());
            });

            return filters;
        }

        function updateAndSendPayload(loadMore = false) {
            showLoadingOverlay();

            let currentFilters = getCurrentFilters();

            let unifiedPayload = {
                action: 'filter_casinos',
                nonce: helper.nonce,
                'casino-category': currentFilters['casino-category'].join(','),
                'vendor': currentFilters['vendor'].join(','),
                'deposit-method': currentFilters['deposit-method'].join(','),
                'withdrawal-method': currentFilters['withdrawal-method'].join(','),
                'withdrawal-limit': currentFilters['withdrawal-limit'].join(','),
                'restricted-country': currentFilters['restricted-country'].join(','),
                'licence': currentFilters['licence'].join(','),
                'casino-language': currentFilters['casino-language'].join(','),
                'currency': currentFilters['currency'].join(','),
                'device': currentFilters['device'].join(','),
                'owner': currentFilters['owner'].join(','),
                'casino-est': currentFilters['casino-est'].join(',')
            };

            if (Object.keys(sliderPayload).length) {
                Object.assign(unifiedPayload, sliderPayload);
            }

            if (loadMore) {
                unifiedPayload.offset = offset;
            }

            $.ajax({
                type: 'POST',
                url: helper.ajaxurl,
                dataType: 'json',
                data: unifiedPayload,
                success: function (res) {
                    if (res.success) {
                        let htmlContent = res.data;
                        let numberOfCasinos = $('<div>').html(htmlContent).find('.card').length;

                        if (loadMore) {
                            $('.list-items-wrap.available-casinos-items-wrap').append(htmlContent);
                            offset += numberOfCasinos;
                        } else {
                            $('.list-items-wrap.available-casinos-items-wrap').html(htmlContent);
                            offset = numberOfCasinos;
                        }

                        if (numberOfCasinos < 12) {
                            $('#load-more-casinos').hide();
                        } else {
                            $('#load-more-casinos').show();
                        }

                        hideLoadingOverlay();
                    } else {
                        console.error("Error:", res.data);
                        hideLoadingOverlay();
                    }
                },
                error: function (xhr, status, error) {
                    console.error("Unified AJAX request failed. Status:", status, "Error:", error);
                    hideLoadingOverlay();
                }
            });
        }

        $('#sort-by').on('change', function () {
            filtersPayload = $(this).val();
            updateAndSendPayload();
        });

        $('#available-casinos-filters .slider-wrap').each(function () {
            var slider = $(this).find('.slider');
            var slider_name = slider.attr('data-name');

            slider.slider({
                stop: function (_, ui) {
                    sliderPayload[`${slider_name}_min`] = ui.values[0];
                    sliderPayload[`${slider_name}_max`] = ui.values[1];
                    updateAndSendPayload();
                }
            });
        });

        $('#load-more-casinos').on('click', function () {
            updateAndSendPayload(true);
        });

        function resetAllParameters() {
            $('#available-casinos-filters .accordion-wrap input[type="checkbox"]').prop('checked', false);
            $('#available-casinos-filters select').val(function () {
                return $('option:first', this).val();
            });
            filtersPayload = null;
            offset = 0;
            updateAndSendPayload();
        }

        $('.accordion-wrap input[type="checkbox"]').on('change', function () {
            offset = 0;
            updateAndSendPayload();
        });
    });
</script>

<?php get_footer(); ?>
