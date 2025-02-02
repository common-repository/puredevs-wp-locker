<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              #
 * @since             1.0.0
 * @package           Puredevs_Wp_Locker
 *
 * @wordpress-plugin
 * Plugin Name:       PureDevs WP Locker
 * Plugin URI:        https://wordpress.org/plugins/puredevs-wp-locker
 * Description:       Use PureDevs WP locker To safeguard your entire WordPress site, by using a single password.
 * Version:           1.0.0
 * Author:            PureDevs
 * Author URI:        https://puredevs.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       puredevs-wp-locker
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'PUREDEVS_WP_LOCKER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-puredevs-wp-locker-activator.php
 */
function pdwl_activate_puredevs_wp_locker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-puredevs-wp-locker-activator.php';
	Puredevs_Wp_Locker_Activator::pdwl_activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-puredevs-wp-locker-deactivator.php
 */
function pdwl_deactivate_puredevs_wp_locker() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-puredevs-wp-locker-deactivator.php';
	Puredevs_Wp_Locker_Deactivator::pdwl_deactivate();
}

register_activation_hook( __FILE__, 'pdwl_activate_puredevs_wp_locker' );
register_deactivation_hook( __FILE__, 'pdwl_deactivate_puredevs_wp_locker' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-puredevs-wp-locker.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function pdwl_run_puredevs_wp_locker() {

	$plugin = new Puredevs_Wp_Locker();
	$plugin->pdwl_run();

}
pdwl_run_puredevs_wp_locker();
