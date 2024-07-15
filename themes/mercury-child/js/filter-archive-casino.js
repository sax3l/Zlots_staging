jQuery(document).ready(function ($) {
    'use strict';

    let offset = 12;
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
