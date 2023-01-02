(function ($) {
  "use strict";
//wow js
  var wow = new WOW({
      animateClass: 'animated',
      offset: 100,
      mobile: false,
      duration: 1000,
  });
  wow.init();


// tabs
  var gallery = $('.gallery_iner');
  if (gallery.length) {
      gallery.imagesLoaded(function () {
          gallery.isotope({
              itemSelector: '.grid-item',
              percentPosition: true,
              masonry: {
                  columnWidth: '.grid-sizer'
              }
          });
      })
  }

  var program = document.getElementById("program_list");

  if (program) {
      $(document).ready(function () {
          var $grid = $('.program_list_filter').isotope({
              itemSelector: '.grid-item',
              layoutMode: 'fitRows',
          });
          var $buttonGroup = $('.filters');
          $buttonGroup.on('click', 'li', function (event) {
              $buttonGroup.find('.is-checked').removeClass('is-checked');
              var $button = $(event.currentTarget);
              $button.addClass('is-checked');
              var filterValue = $button.attr('data-filter');
              $grid.isotope({
                  filter: filterValue
              });
          });
      });
  }


}(jQuery));