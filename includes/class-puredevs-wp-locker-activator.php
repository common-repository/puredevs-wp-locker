<?php

/**
 * Fired during plugin activation
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/includes
 * @author     puredevs <#>
 */
class Puredevs_Wp_Locker_Activator {

	/**
	 * Create database table and login page
	 *
	 *
	 * @since    1.0.0
	 */
	public static function pdwl_activate() {
		global $wpdb;
		$table_name = $wpdb->prefix . "user_ip_address"; 
		$charset_collate = $wpdb->get_charset_collate();

		$sql = "CREATE TABLE $table_name (
		  id mediumint(9) NOT NULL AUTO_INCREMENT,
		  ip_address varchar(15) DEFAULT '' NOT NULL,
		  locked int(2) NOT NULL DEFAULT '0',
		  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
		  PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );

		$query = new WP_Query(
			array(
				'post_type'              => 'page',
				'title'                  => 'Get access',
				'posts_per_page'         => 1,
			)
		);
		
		if ( empty( $query->post ) ) {
			// Create post object
			$login = array(
			  'post_title'    => wp_strip_all_tags( 'Get access' ),
			  'post_content'  => '[pdwl_loginfrm]',
			  'post_status'   => 'publish',
			  'post_author'   => 1,
			  'post_type'     => 'page',
			);

			// Insert the post into the database
			wp_insert_post( $login );
		}
	}

}
