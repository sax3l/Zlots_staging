jQuery(document).ready(function ($) {
    ('use strict');

    // Tabs
    $('ul.tabs li').click(function () {
        var tab_id = $(this).attr('data-tab');

        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $('#' + tab_id).addClass('current');

        // Reinitialize Swiper for the new tab
        new Swiper(".slide-content", {
            slidesPerView: 5,
            spaceBetween: 5,
            loop: true,
            centeredSlides: true,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
                dynamicBullets: true,
            },
            breakpoints: {
                0: {
                    slidesPerView: 1,
                },
                520: {
                    slidesPerView: 2,
                },
                768: {
                    slidesPerView: 3,
                },
                950: {
                    slidesPerView: 4,
                },
                1120: {
                    slidesPerView: 5,
                },
            },
            on: {
                slideChange: function () {
                    var slides = swiper.slides;
                    slides.forEach((slide, index) => {
                        slide.style.transform = `scale(${0.83 + (0.17 * (1 - Math.abs(swiper.realIndex - index)))})`;
                    });
                },
            },
        });
    });

    // Initialize Swiper for the initial tab
    new Swiper(".slide-content", {
        slidesPerView: 5,
        spaceBetween: 5,
        loop: true,
        centeredSlides: true,
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        breakpoints: {
            0: {
                slidesPerView: 1,
            },
            520: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
            },
            950: {
                slidesPerView: 4,
            },
            1120: {
                slidesPerView: 5,
            },
        },
        on: {
            slideChange: function () {
                var slides = swiper.slides;
                slides.forEach((slide, index) => {
                    slide.style.transform = `scale(${0.83 + (0.17 * (1 - Math.abs(swiper.realIndex - index)))})`;
                });
            },
        },
    });

    // Ny JavaScript-kod för att hantera hover-effekten på tabbar
    const tabs = document.querySelectorAll('.tabs .tab-link');
    let currentTab = document.querySelector('.tabs .tab-link.current');

    tabs.forEach(tab => {
        tab.addEventListener('mouseover', function () {
            tabs.forEach(t => t.classList.remove('hovered'));
            tab.classList.add('hovered');
        });

        tab.addEventListener('mouseout', function () {
            tabs.forEach(t => t.classList.remove('hovered'));
            currentTab.classList.add('hovered');
        });

        tab.addEventListener('click', function () {
            tabs.forEach(t => t.classList.remove('current'));
            tab.classList.add('current');
            currentTab = tab;
        });
    });

    // Initial hover-effekt på current tab
    currentTab.classList.add('hovered');
});