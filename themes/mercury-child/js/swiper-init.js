document.addEventListener('DOMContentLoaded', function () {
    if (typeof Swiper !== 'undefined') {
        var swiper = new Swiper('.slide-content', {
            slidesPerView: 5,
            spaceBetween: 5,
            loop: true,
            centeredSlides: true,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
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

        swiper.on('slideChange', function () {
            var slides = swiper.slides;
            slides.forEach((slide, index) => {
                slide.style.transform = `scale(${0.83 + (0.17 * (1 - Math.abs(swiper.realIndex - index)))})`;
            });
        });

    } else {
        console.error('Swiper is not defined');
    }
});
