<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       #
 * @since      1.0.0
 *
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Puredevs_Wp_Locker
 * @subpackage Puredevs_Wp_Locker/admin
 * @author     puredevs <#>
 */
class Puredevs_Wp_Locker_Admin {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/puredevs-wp-locker-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/puredevs-wp-locker-admin.js', array( 'jquery' ), $this->version, false );

	}
	
	/**
	 * Add plugin settings page for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_add_plugin_page() {
		
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

		// This page will be under "Settings"
		add_options_page(__( 'WP Locker Settings', 'puredevs-wp-locker' ), __( 'PureDevs WP Locker', 'puredevs-wp-locker' ), 'manage_options', $this->plugin_name.'-setting', array($this, 'pdwl_create_admin_page'));

	}
	
	/**
	 * Create admin settings page.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_create_admin_page(){
		
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		
        ?>
		<div class="wrap" style="position:relative">
			<h2 class="nav-tab-wrapper">
				<a href="#" class="nav-tab nav-tab-active"><?php esc_html_e( 'General', 'puredevs-wp-locker' ); ?></a>
			</h2> 
                
		    <form method="post" action="options.php" class="<?php echo esc_attr($this->plugin_name); ?>_form">
		        <?php
				settings_fields( $this->plugin_name.'-setting' ); // $option_group( A settings group name. This must match the group name used in register_setting(), which is the page slug name on which the form is to appear. ). To display the hidden fields and handle security of your options form
				do_settings_sections( $this->plugin_name.'-setting' ); // $page The slug name of the page whose settings sections you want to output. This should match the page name used in add_settings_section(). 
				submit_button();
				?>
		    </form>
		</div>
		<?php
    }
	
	/**
	 *  Function that fills the section with the desired content. The function should echo its output.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_print_section_info() {
		echo '<p>'.esc_html__( 'WP Locker general settings section', 'puredevs-wp-locker' ).'</p>';
	}
	
	/**
	 * Generate option page settings sections and fields.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_settings_api_init(){
		
        add_settings_section(
			$this->plugin_name.'_setting_section', // $id - String for use in the 'id' attribute of tags.
			__( 'Settings', 'puredevs-wp-locker' ), // $title - Title of the section.
			array($this, 'pdwl_print_section_info'), // Function that fills the section with the desired content. The function should echo its output.
			$this->plugin_name.'-setting' // $page - The type of settings page on which to show the section (general, reading, writing, media etc.)
		);
		
		$field_id = $this->plugin_name.'_password';
		add_settings_field( //You MUST register any options you use with add_settings_field() or they won't be saved and updated automatically. 
		    $field_id, // $id - String for use in the 'id' attribute of tags.
			__( 'Set Password', 'puredevs-wp-locker' ), // Title of the field.
		    array($this, 'pdwl_create_text_input'), //callback function for text input
		    $this->plugin_name.'-setting', //settings page on which to show the field 
		    $this->plugin_name.'_setting_section',// The section of the settings page in which to show the box
		    array( // The array of arguments to pass to the callback.
				"id" => $field_id,
				"desc" => __( 'Enter a password for your website. Only visitors who know this password will be able to access your site.', 'puredevs-wp-locker' ),
			)			
		);
		
		$field_frm_heading = $this->plugin_name.'_frm_heading';
		add_settings_field( //You MUST register any options you use with add_settings_field() or they won't be saved and updated automatically. 
		    $field_frm_heading, // $id - String for use in the 'id' attribute of tags.
			__( 'Form Heading', 'puredevs-wp-locker' ), // Title of the field.
		    array($this, 'pdwl_create_text_input'), //callback function for text input
		    $this->plugin_name.'-setting', //settings page on which to show the field 
		    $this->plugin_name.'_setting_section',// The section of the settings page in which to show the box
		    array( // The array of arguments to pass to the callback.
				"id" => $field_frm_heading,
				"desc" => __( 'Enter a heading for password form template.', 'puredevs-wp-locker' ),
			)			
		);
		
		$field_sub_btn = $this->plugin_name.'_sub_btn_text';
		add_settings_field( //You MUST register any options you use with add_settings_field() or they won't be saved and updated automatically. 
		    $field_sub_btn, // $id - String for use in the 'id' attribute of tags.
			__( 'Button Label', 'puredevs-wp-locker' ), // Title of the field.
		    array($this, 'pdwl_create_text_input'), //callback function for text input
		    $this->plugin_name.'-setting', //settings page on which to show the field 
		    $this->plugin_name.'_setting_section',// The section of the settings page in which to show the box
		    array( // The array of arguments to pass to the callback.
				"id" => $field_sub_btn,
				"desc" => __( 'Enter submit button label.', 'puredevs-wp-locker' ),
			)			
		);
		
		register_setting( $this->plugin_name.'-setting', $field_id );
		register_setting( $this->plugin_name.'-setting', $field_frm_heading );
		register_setting( $this->plugin_name.'-setting', $field_sub_btn );
    }
	
	/**
	 * Function that fills the field with the desired inputs as part of the larger form. Name and id of the input should match the $id given to this function. The function should echo its output.
	 *
	 * @since    1.0.0
	 */
	public function pdwl_create_text_input($args) {

		if(isset($args["default"])) {
			$default = $args["default"];
		}else{
			$default = false;
		}
		
		echo '<input type="text" id="'  . esc_attr($args["id"]) . '" name="'  . esc_attr($args["id"]) . '" value="' . esc_attr(get_option($args["id"], $default)) . '" />';
		if($args["desc"]) {
			echo "<p class='description'>".esc_html($args["desc"])."</p>";
		}
		
	}

}
