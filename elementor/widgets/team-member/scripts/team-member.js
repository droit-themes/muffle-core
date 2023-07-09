/** @format */

jQuery(function ($) {
  'use strict'

  var teamswiper = new Swiper('.team-section', {
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
        slidesPerView: 3,
        spaceBetween: 20,
      },
      1024: {
        slidesPerView: 3,
        spaceBetween: 20,
      },
    },
  })
})
