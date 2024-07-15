jQuery(document).ready(function ($) {
  ('use strict');

  // Dropdown
  $('.default-option').click(function () {
    $(this).parent().toggleClass('active');
  });

  $('.dropdown-options li').click(function () {
    var current = $(this).html();
    $('.default-option.changing-option li').html(current);
    $(this).parents('.dropdown-wrap').removeClass('active');
  });
});
// dropdown.js

jQuery(document).ready(function($) {
    $('.dropdown-toggle').click(function() {
        $(this).next('.dropdown-menu').slideToggle('fast');
        $(this).toggleClass('active');
    });
});

