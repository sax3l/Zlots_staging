jQuery(document).ready(function ($) {
  ('use strict');

  // Range slider (https://codepen.io/smettana/pen/VjYRNP)
  $('.slider-wrap').each(function () {
    var slider = $(this).find('.slider');
    var slider_min = +slider.attr('data-min');
    var slider_max = +slider.attr('data-max');
    var slider_symbol = slider.attr('data-symbol');
    var slider_values = $(this).siblings('.slider-values');

    slider.slider({
      range: true,
      min: slider_min,
      max: slider_max,
      values: [slider_min, slider_max],

      slide: function (event, ui) {
        slider_values.html(`${ui.values[0]}${slider_symbol} - ${ui.values[1]}${slider_symbol}`);
      },
    });
  });
});
