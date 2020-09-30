<?php

/**
 * Fired during plugin activation
 *
 * @link       https://www.linkedin.com/in/jason-behik-897978a1/
 * @since      1.0.0
 *
 * @package    Aleasleep_Mobile_Buy
 * @subpackage Aleasleep_Mobile_Buy/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Aleasleep_Mobile_Buy
 * @subpackage Aleasleep_Mobile_Buy/includes
 * @author     AleaSleep <jason.e.behik@gmail.com>
 */
class Aleasleep_Mobile_Buy_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		flush_rewrite_rules();
	}

}
