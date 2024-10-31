<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/includes
 * @author     puredevs <#>
 */
class Puredevs_Wp_Locker {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Puredevs_Wp_Locker_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;
	
	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_label    The string used to uniquely identify this plugin.
	 */
	//protected $plugin_label;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'PUREDEVS_WP_LOCKER_VERSION' ) ) {
			$this->version = PUREDEVS_WP_LOCKER_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'puredevs-wp-locker';
		
		$this->pdwl_load_dependencies();
		$this->pdwl_set_locale();
		$this->pdwl_define_admin_hooks();
		$this->pdwl_define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Puredevs_Wp_Locker_Loader. Orchestrates the hooks of the plugin.
	 * - Puredevs_Wp_Locker_i18n. Defines internationalization functionality.
	 * - Puredevs_Wp_Locker_Admin. Defines all hooks for the admin area.
	 * - Puredevs_Wp_Locker_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pdwl_load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-puredevs-wp-locker-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-puredevs-wp-locker-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-puredevs-wp-locker-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-puredevs-wp-locker-public.php';

		$this->loader = new Puredevs_Wp_Locker_Loader();
		
		add_shortcode( 'pdwl_loginfrm', array( $this, 'pdwl_loginfrm_func' ) );
		
	}
	
	/**
	 * Locate template.
	 *
	 * Locate the called template.
	 * Search Order:
	 * 1. /themes/theme/puredevs-wp-locker/$template_name
	 * 2. /themes/theme/$template_name
	 * 3. /plugins/puredevs-wp-locker/templates/$template_name.
	 *
	 * @since 1.0.0
	 *
	 * @param 	string 	$template_name			Template to load.
	 * @param 	string 	$string $template_path	Path to templates.
	 * @param 	string	$default_path			Default path to template files.
	 * @return 	string 							Path to the template file.
	 */
	function pdwl_locate_template( $template_name, $template_path = '', $default_path = '' ) {

		// Set variable to search in woocommerce-plugin-templates folder of theme.
		if ( ! $template_path ) :
			$template_path = 'puredevs-wp-locker/';
		endif;

		// Set default plugin templates path.
		if ( ! $default_path ) :
			$default_path = plugin_dir_path( __FILE__ ) . 'templates/'; // Path to the template folder
		endif;

		// Search template file in theme folder.
		$template = locate_template( array(
			$template_path . $template_name,
			$template_name
		) );

		// Get plugins template file.
		if ( ! $template ) :
			$template = $default_path . $template_name;
		endif;

		return apply_filters( 'pdwl_locate_template', $template, $template_name, $template_path, $default_path );

	}
	
	/**
	 * Get template.
	 *
	 * Search for the template and include the file.
	 *
	 * @since 1.0.0
	 *
	 * @see pdwl_locate_template()
	 *
	 * @param string 	$template_name			Template to load.
	 * @param array 	$args					Args passed for the template file.
	 * @param string 	$string $template_path	Path to templates.
	 * @param string	$default_path			Default path to template files.
	 */
	function pdwl_get_template( $template_name, $args = array(), $tempate_path = '', $default_path = '' ) {
		
		if ( is_array( $args ) && isset( $args ) ) :
			extract( $args );
		endif;

		$template_file = $this->pdwl_locate_template( $template_name, $tempate_path, $default_path );

		if ( ! file_exists( $template_file ) ) :
			_doing_it_wrong( __FUNCTION__, sprintf( '<code>%s</code> does not exist.', $template_file ), '1.0.0' );
			return;
		endif;

		include $template_file;

	}
	
	public function pdwl_loginfrm_func($atts) {
		ob_start();
		$this->pdwl_get_template( 'password-form-template.php' );
		return ob_get_clean();
	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Puredevs_Wp_Locker_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pdwl_set_locale() {

		$plugin_i18n = new Puredevs_Wp_Locker_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'pdwl_load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pdwl_define_admin_hooks() {

		$plugin_admin = new Puredevs_Wp_Locker_Admin( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'pdwl_enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'pdwl_enqueue_scripts' );
		
		
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'pdwl_add_plugin_page' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'pdwl_settings_api_init' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function pdwl_define_public_hooks() {

		$plugin_public = new Puredevs_Wp_Locker_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'pdwl_enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'pdwl_enqueue_scripts' );
		
		
		$this->loader->add_action( 'template_redirect', $plugin_public, 'pdwl_checking_for_frontend' );
		$this->loader->add_action( 'init', $plugin_public, 'pdwl_check_for_password_validation' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_run() {
		$this->loader->pdwl_loader_run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Puredevs_Wp_Locker_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}
	
	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The visitor IP address.
	 */
	public static function pdwl_get_visitor_ip_address(){
		if(!empty($_SERVER['HTTP_CLIENT_IP'])){
			//ip from share internet
			$ip = sanitize_text_field($_SERVER['HTTP_CLIENT_IP']);
		}elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
			//ip pass from proxy
			$ip = sanitize_text_field($_SERVER['HTTP_X_FORWARDED_FOR']);
		}else{
			$ip = sanitize_text_field($_SERVER['REMOTE_ADDR']);
		}
		
		if( !empty( $ip ) && WP_Http::is_ip_address( $ip ) ){
			return $ip;
		}
		return false;
	}

}
