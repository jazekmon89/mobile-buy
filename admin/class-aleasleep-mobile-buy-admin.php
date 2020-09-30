<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.linkedin.com/in/jason-behik-897978a1/
 * @since      1.0.0
 *
 * @package    Aleasleep_Mobile_Buy
 * @subpackage Aleasleep_Mobile_Buy/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Aleasleep_Mobile_Buy
 * @subpackage Aleasleep_Mobile_Buy/admin
 * @author     AleaSleep <jason.e.behik@gmail.com>
 */
class Aleasleep_Mobile_Buy_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/aleasleep-mobile-buy-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/aleasleep-mobile-buy-admin.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Register the plugin's settings menu for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function show_plugin_setup_menu() {
		add_options_page( 'Mobile Buy Settings', 'Mobile Buy', 'manage_options', $this->plugin_name, [$this, 'show_plugin_template'] );
	}

	/**
	 * Register the plugin's template for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function show_plugin_template() {
		include_once('partials/aleasleep-mobile-buy-admin-display.php');
	}

	/**
	 * Add plugin's settings link to the plugins page.
	 *
	 * @since 1.0.0
	 */
	public function add_action_links( $links ) {
		$settings_link = array(
			'<a href="' . admin_url( 'options-general.php?page=' . $this->plugin_name ) . '">' . __('Settings', $this->plugin_name) . '</a>',
		);
		return array_merge( $settings_link, $links );
	}

	/**
	 * Register the plugin's settings updater.
	 *
	 * @since 1.0.0
	 */
	public function options_update() {
	    register_setting($this->plugin_name, $this->plugin_name, array($this, 'validate'));
	}

	/**
	 * Validate and clean the request.
	 *
	 * @since 1.0.0
	 */
	public function validate($input) {
		$valid = [];
		$valid['mobile_buy_status'] = (isset($input['mobile_buy_status']) && !empty($input['mobile_buy_status'])) ? 1 : 0;
		$valid['mobile_buy_text'] = !empty($input['mobile_buy_text']) ? $input['mobile_buy_text'] : 'Buy';
		//$valid['page_id'] = is_page(intval($input['page_id'])) ? $input['page_id'] : 0;
		$valid['mobile_buy_cart_slug'] = $this->correct_slug_name($input['mobile_buy_cart_slug']);
		flush_rewrite_rules();
		return $valid;
	}

	/**
	 * Slug name corrector.
	 *
	 * @since 1.0.0
	 */
	private function correct_slug_name($slug_name) {
		$slug_name = str_replace(' ', '_', $slug_name);
		$slug_name = preg_replace("/[^a-zA-Z-]/", "", $slug_name);
		return $slug_name;
	}
}
