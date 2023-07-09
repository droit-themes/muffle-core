/** @format */

jQuery(function ($) {
  'use strict'

  var serviceSwiper = new Swiper('.service_slider', {
    speed: 2500,
    slidesPerView: 3,
    centeredSlides: true,
    spaceBetween: 10,
    loop: true,
    loopedSlides: 3,
    autoplay: {
      delay: 3000,
      disableOnInteraction: false,
    },
    pagination: {
      el: '.swiper-pagination',
      clickable: true,
    },
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 20,
      },
      768: {
        slidesPerView: 2,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3.5,
        spaceBetween: 20,
      },
    },
  })
})
