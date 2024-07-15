jQuery(document).ready(function ($) {
  ('use strict');

  // Mobile menu (https://codepen.io/joloveridge/pen/wJMWRN)
  /* Hamburger menu animation */
  $('.mobile-menu-button').click(function () {
    $(this).toggleClass('open');
  });

  /* Menu fade/in out on mobile */
  $('.mobile-menu-button').click(function (e) {
    e.preventDefault();
    $('.mobile-menu').toggleClass('open');
  });

  /* Close menu using the escape key */
  $(document).keyup(function (e) {
    if (e.keyCode == 27) {
      // escape key maps to keycode `27`
      if ($('.mobile-menu').hasClass('open')) {
        $('.mobile-menu').removeClass('open');
      }

      if ($('.mobile-menu-button').hasClass('open')) {
        $('.mobile-menu-button').removeClass('open');
      }

      if ($('body').hasClass('lock-scroll')) {
        $('body').removeClass('lock-scroll');
      }
    }
  });

  // When mobile hamburger menu button is clicked, add lock-scroll class to body. This stops the user being able to scroll the page behind the menu.

  $('.mobile-menu-button').click(function () {
    // If the menu is already open, we need to remove the scroll lock
    if ($(this).hasClass('open')) {
      lockScroll(true);
    } else {
      lockScroll(false);
    }
  });

  function lockScroll(shouldLock) {
    if (shouldLock === undefined) {
      shouldLock = true;
    }

    if (shouldLock) {
      if (!$('body').hasClass('lock-scroll')) {
        $('body').addClass('lock-scroll');
      }
    } else {
      if ($('body').hasClass('lock-scroll')) {
        $('body').removeClass('lock-scroll');
      }
    }
  }
});
