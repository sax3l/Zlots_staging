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
            'vendor': []
        };

        $('#available-casinos-filters .accordion-wrap input[name="casino-category"]:checked').each(function () {
            filters['casino-category'].push($(this).val());
        });

        $('#available-casinos-filters .accordion-wrap input[name="vendor"]:checked').each(function () {
            filters['vendor'].push($(this).val());
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
            'vendor': currentFilters['vendor'].join(',')
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
                        $('#load-more').hide();
                    } else {
                        $('#load-more').show();
                    }
                } else {
                    console.error("Error:", res.data);
                }

                hideLoadingOverlay();
            },
            error: function (xhr, status, error) {
                console.error("AJAX request failed. Status:", status, "Error:", error);
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

    $('#load-more').on('click', function () {
        updateAndSendPayload(true);
    });

    $('.accordion-wrap input[type="checkbox"]').on('change', function () {
        offset = 0;
        updateAndSendPayload();
    });
});
