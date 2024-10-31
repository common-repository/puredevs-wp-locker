<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/includes
 * @author     puredevs <#>
 */
class Puredevs_Wp_Locker_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_load_plugin_textdomain() {

		load_plugin_textdomain(
			'puredevs-wp-locker',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
