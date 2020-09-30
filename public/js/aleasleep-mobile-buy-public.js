(function( $ ) {

	'use strict';



	/**

	 * All of the code for your public-facing JavaScript source

	 * should reside in this file.

	 *

	 * Note: It has been assumed you will write jQuery code here, so the

	 * $ function reference has been prepared for usage within the scope

	 * of this function.

	 *

	 * This enables you to define handlers, for when the DOM is ready:

	 *

	 * $(function() {

	 *

	 * });

	 *

	 * When the window is loaded:

	 *

	 * $( window ).load(function() {

	 *

	 * });

	 *

	 * ...and/or other possibilities.

	 *

	 * Ideally, it is not considered best practise to attach more than a

	 * single DOM-ready or window-load handler for a particular page.

	 * Although scripts in the WordPress core, Plugins and Themes may be

	 * practising this, we should strive to set a better example in our own work.

	 */



 	$( window ).load(function() {

	 	// we only execute the event binding if we see the add to cart options

		if ($('.variations .button-options').length) {

			$('.variations .button-options').attr('disabled', false);

			$('.variations .button-options').on('click', function(e) {

				e.preventDefault();

				if (!$(this).hasClass('selected')) {

					$('.variations .button-options.selected').removeClass('selected');

					$(this).addClass('selected');

					$("input[name='attribute_size']").val($(this).attr('data-val'));

					$("input[name='variation_id']").val($(this).attr('data-id'));

				}

			});

		}

		if ($(window).width() <= 767) {
			var main_header_height = $('#main-header').height();
			var promo_header_container_height = $('.promo-header-container').height();

			$('.single-product-page-header').css({'transform': 'translateY(' + (main_header_height + promo_header_container_height) + 'px)' , 'position' : 'fixed', 'top': '0px'});

			$(window).scroll(function() {
				

				if($(window).scrollTop() >= (main_header_height + promo_header_container_height)){

					$('.single-product-page-header').css({'transform' : 'translateY('+ main_header_height +'px)'});
				}

				if($(window).scrollTop() == 0){
					$('.single-product-page-header').css({'transform' : 'translateY('+ (main_header_height + promo_header_container_height) +'px)'});
				}
			});

			}
		});

		
		


	});



})( jQuery );

