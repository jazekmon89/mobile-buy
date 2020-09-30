<?php



/**

 * Provide a public-facing view for the plugin

 *

 * This file is used to markup the public-facing aspects of the plugin.

 *

 * @link       https://www.linkedin.com/in/jason-behik-897978a1/

 * @since      1.0.0

 *

 * @package    Aleasleep_Mobile_Buy

 * @subpackage Aleasleep_Mobile_Buy/public/partials

 */



global $product;

$product_id = $product->get_id();

$product_obj_temp = new WC_Product_Factory();

$product_obj_temp = $product_obj_temp->get_product( $product_id );

$variations = $product_obj_temp->get_available_variations();

$lowest_price = 0;

$price = '';

$zero_price_html = '';

foreach ( $variations as $variation ) {

	$variation_price = $variation[ 'display_price' ] < $variation[ 'display_regular_price' ] ? $variation[ 'display_price' ] : $variation[ 'display_regular_price' ];

	if ( $variation_price == 0 ) {

		$zero_price_html = '0';

	}

	if ( $lowest_price == 0 || ( $lowest_price > 0 && $variation_price < $lowest_price ) ) {

		$lowest_price = $variation_price;

	}

}

if ( !empty( $zero_price_html ) ) {

	$lowest_price = 0;

}

$lowest_price = get_woocommerce_currency_symbol() . $lowest_price;

$options = get_option( $this->plugin_name );

$request_uri = explode( '?', $_SERVER[ 'REQUEST_URI' ] );

$request_uri = $request_uri[0];

$add_to_cart_url = $request_uri . $options[ 'mobile_buy_cart_slug' ] . '?id=' . $product_id;

?>



<div class='mobile-buy'>

	<div class='description'>

		<div class='up'>

			Starting at <?php echo $lowest_price; ?>

		</div>

		<div class='down'>

			<?php echo count( $variations ); ?> sizes available

		</div>

	</div>

	<a class='button' href='<?php echo $add_to_cart_url;?>'>

		<?php echo $options['mobile_buy_text']; ?>

	</a>

</div>

<script type="text/javascript">
	(function( $ ) {
		$( window ).load(function() {

			if (jQuery(window).width() <= 767) {



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


	})( jQuery );
</script>>