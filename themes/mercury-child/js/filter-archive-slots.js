	jQuery(document).ready(function($) {
    'use strict';

    // Initialize global variables
    let offset = 12;
    let sliderPayload = {};
    let dropdownSortPayload = null;

    // Show loading overlay
    function showLoadingOverlay() {
        $('.loading-overlay').css('display', 'flex');
    }

    // Hide loading overlay
    function hideLoadingOverlay() {
        $('.loading-overlay').css('display', 'none');
    }

    // Function to gather current filter settings
    function getCurrentFilters() {
        let filters = {
            'game-category': [],
            'vendor': []
        };

        $('#slots-archive-filters .accordion-wrap input[name="game-category"]:checked').each(function() {
            filters['game-category'].push($(this).val());
        });

        $('#slots-archive-filters .accordion-wrap input[name="vendor"]:checked').each(function() {
            filters['vendor'].push($(this).val());
        });

        return filters;
    }

    // Unified function to update and send payload for slots
    function updateAndSendPayload(loadMore = false) {
        showLoadingOverlay();

        let currentFilters = getCurrentFilters();

        let unifiedPayload = {
            action: 'filter_slots',
            nonce: helper.nonce,
            'game-category': currentFilters['game-category'].join(','),
            'vendor': currentFilters['vendor'].join(',')
        };

        if (Object.keys(sliderPayload).length) {
            Object.assign(unifiedPayload, sliderPayload);
        }

        if (dropdownSortPayload) {
            unifiedPayload.sort_by = dropdownSortPayload;
        }

        if (loadMore) {
			offset += 12;
            unifiedPayload.offset = offset; // Use global offset for load more functionality
        }

        console.log("Unified AJAX data payload:", unifiedPayload);

        $.ajax({
            type: 'POST',
            url: helper.ajaxurl,
            dataType: 'json',
            data: unifiedPayload,
            success: function(res) {
                console.log("Unified AJAX request successful. Response:", res);
                let htmlContent = res[0];
                let numberOfSlots = $('<div>').html(htmlContent).find('.slot-item-wrap').length;

                if (loadMore) {
                    $('.list-items-wrap.slots-archive-items-wrap').append(htmlContent);
                    offset += numberOfSlots; // Make sure to increment by the actual number of slots returned
                } else {
                    $('.list-items-wrap.slots-archive-items-wrap').replaceWith('<div class="list-items-wrap slots-archive-items-wrap">' + htmlContent + '</div>');
                    offset = numberOfSlots; // Reset offset based on the new query
                }

				if (numberOfSlots > 0) {
                    if (loadMore) {
                        $('.list-items-wrap.slots-archive-items-wrap').append(htmlContent);
                    } else {
                        $('.list-items-wrap.slots-archive-items-wrap').replaceWith('<div class="list-items-wrap slots-archive-items-wrap">' + htmlContent + '</div>');
                    }
                    offset += numberOfSlots;
                } else {
                    $('.list-items-wrap.slots-archive-items-wrap').replaceWith('<div class="list-items-wrap slots-archive-items-wrap"><div class="card-nocasfound"><h3 class="card-nocasfoundtext">No Casinos Found!</h3><button id="resetParametersBtn" class="mainstylebutton" type="button">Reset Parameters</button></div></div>');
                    $('#resetParametersBtn').click(function() {
                        resetAllParameters();
                    });
                }
				
                if (numberOfSlots < 12) {
                    $('#load-more-slots').hide();
                } else {
                    $('#load-more-slots').show();
                }

                hideLoadingOverlay();
            },
            error: function(xhr, status, error) {
                console.error("Unified AJAX request failed. Status:", status, "Error:", error);
                hideLoadingOverlay();
            }
        });
    }

    // Sorting slots
    $('#sort-by').on('change', function() {
        dropdownSortPayload = $(this).val();
        updateAndSendPayload();
    });

    // Slider for filtering slots
    $('#slots-archive-filters .slider-wrap').each(function() {
        var slider = $(this).find('.slider');
        var slider_name = slider.attr('data-name');

        slider.slider({
            stop: function(_, ui) {
                sliderPayload[`${slider_name}_min`] = ui.values[0];
                sliderPayload[`${slider_name}_max`] = ui.values[1];
                updateAndSendPayload();
            }
        });
    });

    // Load more slots
    $('#load-more-slots').on('click', function() {
        updateAndSendPayload(true);
    });

    // Reset all filters for slots
    function resetAllParameters() {
        // Reset checkboxes
        $('#slots-archive-filters .accordion-wrap input[type="checkbox"]').prop('checked', false);

        // Reset dropdowns, assuming the first option is the default
        $('#slots-archive-filters select').val(function() {
            return $('option:first', this).val();
        });
        dropdownSortPayload = null;

        // Reset the offset
        offset = 0;

        // Call updateAndSendPayload to fetch and display the initial slots
        updateAndSendPayload();
    }

    // Event listener for checkbox changes within the accordion
    $('.accordion-wrap input[type="checkbox"]').on('change', function() {
        offset = 0; // Reset offset if starting a new filter operation
        updateAndSendPayload();
    });

		
});
