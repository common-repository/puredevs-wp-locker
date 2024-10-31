<?php

/**
 * Fired when the plugin is uninstalled.
 *
 * When populating this file, consider the following flow
 * of control:
 *
 * - This method should be static
 * - Check if the $_REQUEST content actually is the plugin name
 * - Run an admin referrer check to make sure it goes through authentication
 * - Verify the output of $_GET makes sense
 * - Repeat with other user roles. Best directly by using the links/query string parameters.
 * - Repeat things for multisite. Once for a single site in the network, once sitewide.
 *
 * This file may be updated more in future version of the Boilerplate; however, this is the
 * general skeleton and outline for how the file should work.
 *
 * For more information, see the following discussion:
 * https://github.com/tommcfarlin/WordPress-Plugin-Boilerplate/pull/123#issuecomment-28541913
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Puredevs_Wp_Locker
 */

// If uninstall not called from WordPress, then exit.
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

global $wpdb;
$table_name = $wpdb->prefix . "user_ip_address"; 
$wpdb->query( $wpdb->prepare( "DROP TABLE IF EXISTS %i", $table_name ) );

$query = new WP_Query(
    array(
        'post_type'              => 'page',
        'title'                  => 'Get access',
        'posts_per_page'         => 1,
    )
);

if ( ! empty( $query->post ) ) {
    wp_delete_post($query->post->ID, true);
}


delete_option( 'puredevs-wp-locker_password' );
delete_option( 'puredevs-wp-locker_frm_heading' );
delete_option( 'puredevs-wp-locker_sub_btn_text' );
setcookie("gain_access", "", time() - 3600);
