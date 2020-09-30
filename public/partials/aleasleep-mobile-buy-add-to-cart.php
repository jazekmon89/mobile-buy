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



defined( 'ABSPATH' ) || exit;



global $product;



$attributes = $product->get_variation_attributes();

$available_variations = $product->get_available_variations();

$default_attributes = $product->get_default_attributes();

$image = wp_get_attachment_image_src( get_post_thumbnail_id( $product->id ), 'single-post-thumbnail' );



// we have to correct the product's permalink if it's not using the current host in url.

$permalink_url = parse_url( $product->get_permalink() );

$site_url = parse_url($_SERVER['HTTP_REFERER']);//parse_url( get_site_url() );

$action_url = $product->get_permalink();

if ( ( $permalink_url[ 'scheme' ] != $site_url[ 'scheme' ] ) || ( $permalink_url['host'] != $site_url['host'] ) ) {

	$action_url = $site_url['host'] . $permalink_url['path'];

}



//$attribute_keys = array_keys( $attributes );



do_action( 'woocommerce_before_add_to_cart_form' ); ?>



<div class="full-width-image">

	<img src="<?php  echo $image[0]; ?>">

</div>



<form class="variations_form cart custom-page" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $action_url ) ); ?>" method="post" enctype='multipart/form-data' data-product_id="<?php echo absint( $product->get_id() ); ?>" data-product_variations="<?php echo htmlspecialchars( wp_json_encode( $available_variations ) ); // WPCS: XSS ok. ?>">

	<?php do_action( 'woocommerce_before_variations_form' ); ?>



	<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>

		<p class="stock out-of-stock"><?php esc_html_e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>

	<?php else : ?>

		<div class="variations" cellspacing="0">


				<?php foreach ( $attributes as $attribute_name => $options ) : ?>

					<?php $attribute_name_slug = esc_attr( sanitize_title( $attribute_name ) ); ?>

					<div>

						<div class="label">
							<label for="<?php echo $attribute_name_slug; ?>">Select <?php echo wc_attribute_label( $attribute_name ); // WPCS: XSS ok. ?></label>
						</div>

						<div class="value">

							<?php

								$selected = isset( $default_attributes[ $attribute_name_slug ] ) ? $default_attributes[ $attribute_name_slug ] : '';

								echo "<input type='hidden' class='attribute_" . $attribute_name_slug . "' name='attribute_" . $attribute_name_slug . "' value='" . $selected . "'>";

								foreach ( $available_variations as $variation) {

									// let's get the size attribute

									$variation_id = $variation[ 'variation_id' ];

									$variation = new WC_Product_Variation( $variation_id );

									$variation_attribute = $variation->get_variation_attributes();

									$variation_attribute = $variation_attribute[ 'attribute_size' ];



									// we determine the default selected attribute.

									$selected = $selected == $variation_attribute ? 'selected' : '';

									

									// let's get the lowest price

									$price = $variation->get_price();

									$regular_price = $variation->get_regular_price();

									$sale_price = $variation->get_sale_price();

									$lowest_price = $price < $regular_price ? $price : $regular_price;

									$lowest_price = $lowest_price < $sale_price ? $lowest_price : $sale_price;



									// price being formatted by adding comma to specific decimal places

									$lowest_price = number_format($lowest_price);

									

									// now we just display our sizes and their respective price.

									echo "<button type='button' class='button-options " . $selected . "' data-val='".$variation_attribute."' data-id='" . $variation_id . "' disabled><div class='option-name'>" . $variation_attribute . "</div><div class='option-price'>" . get_woocommerce_currency_symbol() . $lowest_price . "</div>";

								}

							?>

						</div>
					</div>

				<?php endforeach; ?>

	

		</div>



		<div class="single_variation_wrap">

			<?php

				/**

				 * Hook: woocommerce_before_single_variation.

				 */

				do_action( 'woocommerce_before_single_variation' );



				/**

				 * Hook: woocommerce_single_variation. Used to output the cart button and placeholder for variation data.

				 *

				 * @since 2.4.0

				 * @hooked woocommerce_single_variation - 10 Empty div for variation data.

				 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.

				 */

				do_action( 'woocommerce_single_variation' );



				/**

				 * Hook: woocommerce_after_single_variation.

				 */

				do_action( 'woocommerce_after_single_variation' );

			?>

		</div>

	<?php endif; ?>



	<?php //do_action( 'woocommerce_after_variations_form' ); ?>

</form>



<?php

//do_action( 'woocommerce_after_add_to_cart_form' );