<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/jason-behik-897978a1/
 * @since      1.0.0
 *
 * @package    Aleasleep_Mobile_Buy
 * @subpackage Aleasleep_Mobile_Buy/public
 */

if ( ! class_exists( 'Gamajo_Template_Loader' ) ) {
  require plugin_dir_path( __FILE__ ) . '../includes/class-aleasleep-mobile-buy-gamajo-template-loader.php';
}

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Aleasleep_Mobile_Buy
 * @subpackage Aleasleep_Mobile_Buy/public
 * @author     AleaSleep <jason.e.behik@gmail.com>
 */
class Aleasleep_Mobile_Buy_Public extends Gamajo_Template_Loader {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->filter_prefix = $plugin_name;
		$this->version = $version;
		$this->plugin_directory = plugin_dir_path( dirname( __FILE__ ) );

	}

	/**
	 * Prefix for filter names.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $filter_prefix = '';

	/**
	 * Directory name where custom templates for this plugin should be found in the theme.
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $theme_template_directory = 'public/partials';

	/**
	 * Reference to the root directory path of this plugin.
	 *
	 * Can either be a defined constant, or a relative reference from where the subclass lives.
	 *
	 * In this case, `MEAL_PLANNER_PLUGIN_DIR` would be defined in the root plugin file as:
	 *
	 * ~~~
	 * define( 'MEAL_PLANNER_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
	 * ~~~
	 *
	 * @since 1.0.0
	 *
	 * @var string
	 */
	protected $plugin_directory = '';

	/**
	 * Directory name where templates are found in this plugin.
	 *
	 * Can either be a defined constant, or a relative reference from where the subclass lives.
	 *
	 * e.g. 'templates' or 'includes/templates', etc.
	 *
	 * @since 1.1.0
	 *
	 * @var string
	 */
	protected $plugin_template_directory = 'public/partials';

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Aleasleep_Mobile_Buy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aleasleep_Mobile_Buy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aleasleep-mobile-buy-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Aleasleep_Mobile_Buy_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Aleasleep_Mobile_Buy_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/aleasleep-mobile-buy-public.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Add the query var for the custom page
	 */
	public function custom_page_set_query_var( $vars ) {
		// ref url redirected to in add rewrite rule
	    array_push( $vars, 'id' );
	    return $vars;
	}


	/**
	 * Add the rewrite url for the custom page
	 */
	public function custom_page_add_rewrite_rule() {
		$options = get_option( $this->plugin_name );
		if ( $options['mobile_buy_status'] ) {
			add_rewrite_rule( '^' . $options[ 'mobile_buy_cart_slug' ] . '$', 'index.php?id=$matches[1]', 'bottom' );
		}
	}

	/**
	 * Checks if access to the url is valid
	 */
	public function is_valid_access() {
		$options = get_option( $this->plugin_name );
		if ( $options['mobile_buy_status'] ) {
			// get the request uri, should have the slug name in the full url
			$request_uri = explode( '/', $_SERVER["REQUEST_URI"] );

			// should have 'product' in the path as well
			if ( in_array( 'product', $request_uri ) ) {
				// we have to get the page's slug name
				$page_slug = count( $request_uri );
				$page_slug = $page_slug >= 2 ? $request_uri[$page_slug-2] : '';

				// now get the last part of the path
				$request_uri = end($request_uri);
				$request_uri = explode('?', $request_uri);
				$request_uri = $request_uri[0];

				// get the slug name of the custom page
				$page = $options['mobile_buy_cart_slug'];

				// we have to check the id if it's valid and numeric
				$id = get_query_var( 'id' );
				$id = is_numeric( $id ) ? abs( intval( $id ) ) : 0;

				/* this is how we filter who can access the custom page
				 * - request uri and from plugin setting's slug should match
				 * - query string should contain the product id
				 * - and if page is accessed by a mobile browser
				 */
				if ( $request_uri == $page && $id && wp_is_mobile() ) {
					return 1;
				} else if( !$id ) {//  && wp_is_mobile() ) {
					// we're in the main product page.
					// we have to apply some changes here.
					return 2;
				} else if( $request_uri == $page && $id ) {// && !wp_is_mobile() ) {
					return 3;
				}
			}
		}
		return 0;
	}

	/**
	 * Use the plugin's partial template
	 */
	public function custom_page_include_template( $template ) {
		// check if permitted to access the url
		$access = $this->is_valid_access();
		if ( !$access ) {
			return $template;
		}

		// we have to add our customizations (buy button) for the main product page
		if ( $access === 2 ) {
			global $product;
			$product_obj = get_page_by_path( $product, OBJECT, 'product' );
			$product_obj_temp = new WC_Product_Factory();
			$product_obj_temp = $product_obj_temp->get_product( $product_obj->ID );
			if ($product_obj_temp) {
				wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aleasleep-mobile-buy-public-main-product-page.css', array(), $this->version, 'all' );
				add_filter( 'wp_footer', function() {
					ob_start();
					require plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/aleasleep-mobile-buy-public-display.php';
					$template = ob_get_contents();
					$content .= $template;
					ob_end_clean();
					echo $content;
				}, 15 );
			}
			return $template;
		}

		/**
		 * if all conditions satisfied but page is not accessed through mobile,
		 * let's just stay in page (it will show the 404 page)
		 */ 
		if ( $access === 3 ) {
			return $template;
		}

		// get the page's slug name
		$request_uri = explode( '/', $_SERVER["REQUEST_URI"] );
		$page_slug = count( $request_uri );
		$page_slug = $page_slug >= 2 ? $request_uri[ $page_slug - 2 ] : '';

		/* we query for the product id to be able to proceed
		 * instead of getting a 404 error
		 */
		global $wp_query;
		$params = [
			'posts_per_page' => 1,
			'name' => $page_slug,
			'post_type' => 'product',
			'post__in' => [ get_query_var( 'id' ) ]
		];
		$wp_query = new WP_Query( $params );
		// check if we have valid post for the given product id
		if ($wp_query->have_posts()) {
			// add the styles for the custom mobile add to cart page.
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aleasleep-mobile-buy-public-add-to-cart-page.css', array(), $this->version, 'all' );
			// remove the default woocommerce single product add to cart template
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
			// remove shortcode output in mobile cart page
			add_filter('do_shortcode_tag', function() {
				return '';
			}, 10, 2);
			// replace it with our own add to cart
			add_filter( 'woocommerce_single_product_summary', function() {
				ob_start();
				require plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials/aleasleep-mobile-buy-add-to-cart.php';
				$template = ob_get_contents();
				$content .= $template;
				ob_end_clean();
				echo $content;
			}, 30 );
		}

		return $template;
	}

}
