/**
 * File products-swiper.js.
 *
 * Theme Customizer enhancements for a better user experience.
 *
 * Contains handlers to make Theme Customizer preview reload changes asynchronously.
 */

(function (jQuery) {
	"use strict";

	jQuery(document).ready(function () {
		if (jQuery(document).find('.product-single-slider').length > 0) {

			jQuery(document).find('.product-single-slider').each(function () {
				let slider = jQuery('.product-single-slider>.swiper-wrapper');
				var config;

				if (slider.parent('.product-single-slider').hasClass("image-slider")) {
					config = {
						slidesToShow: 1,
						loop: true,
						prevArrow: '.swiper-button-prev',
						nextArrow: '.swiper-button-next',
					}
				}


				if (slider.parent('.product-single-slider').hasClass("related-slider") || slider.parent('.product-single-slider').hasClass("upsells-slider")) {
					config = {
						slidesToShow: 5,
						loop: true,
						nextArrow: '<a href="#" class="slick-arrow slick-next"><i class= "fa fa-chevron-right"></i></a>',
						prevArrow: '<a href="#" class="slick-arrow slick-prev"><i class= "fa fa-chevron-left"></i></a>',
						responsive: [
							{
								breakpoint: 1366,
								settings: {
									slidesToShow: 5,
									infinite: true,
									dots: false
								}
							},
							{
								breakpoint: 1199,
								settings: {
									slidesToShow: 4
								}
							},
							{
								breakpoint: 768,
								settings: {
									slidesToShow: 3
								}
							},
							{
								breakpoint: 480,
								settings: {
									slidesToShow: 2
								}
							},
							{
								breakpoint: 400,
								settings: {
									slidesToShow: 2
								}
							}
						]
					}
				}
				slider.slick(config).slickAnimation();
			});
			/* Resize window on load */
			window.dispatchEvent(new Event('resize'));
		}

	});


}(jQuery));
