jQuery(document).ready(function ($) {
  ('use strict');

  // Accordion
  $('.accordion-wrap .set > p').on('click', function () {
    if ($(this).hasClass('active')) {
      $(this).removeClass('active');
      $(this).siblings('.accordion-wrap .content').slideUp(200);
      $('.accordion-wrap .set > p i').removeClass('fa-angle-up').addClass('fa-angle-down');
    } else {
      $('.accordion-wrap .set > p i').removeClass('fa-angle-up').addClass('fa-angle-down');
      $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
      $('.accordion-wrap .set > p').removeClass('active');
      $(this).addClass('active');
      $('.accordion-wrap .content').slideUp(200);
      $(this).siblings('.accordion-wrap .content').slideDown(200);
    }
  });
});
// accordion.js

jQuery(document).ready(function($) {
    $('.accordion-toggle').click(function() {
        $(this).next('.accordion-content').slideToggle('fast');
        $(this).toggleClass('active');
    });
});
