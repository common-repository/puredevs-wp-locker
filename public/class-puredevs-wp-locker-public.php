<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/public
 * @author     puredevs <#>
 */
class Puredevs_Wp_Locker_Public {

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
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Puredevs_Wp_Locker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Puredevs_Wp_Locker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/puredevs-wp-locker-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Puredevs_Wp_Locker_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Puredevs_Wp_Locker_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/puredevs-wp-locker-public.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Checking for visitors allowed to access frontend page or not.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_checking_for_frontend(){
		
		if ( !is_user_logged_in() ) {
			if ( ! is_admin() ) {
				if ( is_page( array( 'get-access' ) ) ) {
					global $wpdb;
					$table_name = $wpdb->prefix . "user_ip_address"; 
					$visitor_ip = Puredevs_Wp_Locker::pdwl_get_visitor_ip_address();
					$visitor_id = $wpdb->get_var(  $wpdb->prepare( "SELECT id FROM %i WHERE ip_address = %s", $table_name, $visitor_ip ) );
					if( isset($_COOKIE['gain_access']) || $visitor_id ) {
						wp_redirect( home_url() );
						exit();
					}
				}else{
					$cookie_name = "gain_access";
					if(isset($_COOKIE[$cookie_name])) {
					}else{
						global $wpdb;
						$table_name = $wpdb->prefix . "user_ip_address"; 
						$visitor_ip = Puredevs_Wp_Locker::pdwl_get_visitor_ip_address();
						$visitor_id = $wpdb->get_var( $wpdb->prepare( "SELECT id FROM %i WHERE ip_address = %s", $table_name, $visitor_ip ) );
						if(is_null($visitor_id)){
							wp_redirect( home_url( '/get-access/' ) );
							exit();
						}else{
							$cookie_value = true;
							setcookie($cookie_name, $cookie_value, 0, "/");
						}
					}
				}
			}
		} elseif( is_user_logged_in() && is_page( array('get-access') ) ) {
			wp_redirect( home_url() );
			exit();
		}
		
	}
	
	/**
	 * Checking for visitors enter password is valid or not.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_check_for_password_validation(){
		if( isset( $_POST['psw'] ) && ( isset( $_POST['pdwl_loginfrm_nonce_field'] ) && wp_verify_nonce( $_POST['pdwl_loginfrm_nonce_field'], 'pdwl_loginfrm_action' ) ) ){
			$psw = sanitize_text_field($_POST['psw']);
			$locker_password = get_option( 'puredevs-wp-locker_password' );
			if($locker_password == $psw){
				global $wpdb;
				$table_name = $wpdb->prefix . "user_ip_address"; 
				$visitor_ip = Puredevs_Wp_Locker::pdwl_get_visitor_ip_address();
				if($visitor_ip){
					$wpdb->insert( 
						$table_name, 
						array( 
							'ip_address' => $visitor_ip,
						), 
						array( 
							'%s', 
						) 
					);
				}
				$cookie_name = "gain_access";
				$cookie_value = true;
				setcookie($cookie_name, $cookie_value, 0, "/");
				wp_redirect( home_url() );
				exit();
			}else{
				wp_redirect( home_url( '/get-access/?valid=false' ) );
				exit();
			}
		}elseif( isset( $_POST['psw'] ) && ( ! isset( $_POST['pdwl_loginfrm_nonce_field'] ) || ! wp_verify_nonce( $_POST['pdwl_loginfrm_nonce_field'], 'pdwl_loginfrm_action' ) ) ){
			wp_redirect( home_url( '/get-access/?n_valid=false' ) );
			exit();
		}
		
	}

}
