/** @format */

jQuery(function ($) {
	'use strict';

	/*--------------- Start popup-js--------*/
	function popupGallery() {
		if ($('.popup-youtube').length) {
			$('.popup-youtube').magnificPopup({
				disableOn: 700,
				type: 'iframe',
				removalDelay: 160,
				preloader: false,
				fixedContentPos: false,
				mainClass: 'mfp-with-zoom mfp-img-mobile',
			});
		}
	}
	popupGallery();
});
