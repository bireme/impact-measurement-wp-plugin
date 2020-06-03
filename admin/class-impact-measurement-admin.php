<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://reddes.bvsalud.org/
 * @since      1.0.0
 *
 * @package    Impact_Measurement
 * @subpackage Impact_Measurement/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Impact_Measurement
 * @subpackage Impact_Measurement/admin
 * @author     BIREME/OPAS/OMS <ofibireme@paho.org>
 */
class Impact_Measurement_Admin {

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
		 * defined in Impact_Measurement_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Impact_Measurement_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/impact-measurement-admin.css', array(), $this->version, 'all' );

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
		 * defined in Impact_Measurement_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Impact_Measurement_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/impact-measurement-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function admin_menu() {
        add_options_page(__('Impact Measurement settings', 'impact-measurement'), __('Impact Measurement', 'impact-measurement'),
            'manage_options', 'im-settings', array(&$this, 'impact_measurement_page_admin'));
        //call register settings function
        add_action('admin_init', array(&$this, 'register_settings'));
    }

    public function register_settings(){
        register_setting('impact-measurement-settings-group', 'impact_measurement_config');
    }

    public function impact_measurement_settings_link( $links ) {
		// Build and escape the URL.
		$url = esc_url( add_query_arg(
			'page',
			'im-settings',
			get_admin_url() . 'admin.php'
		) );

		// Create the link.
		$settings_link = "<a href='$url'>" . __( 'Settings' ) . '</a>';

		// Adds the link to the end of the array.
		array_push(
			$links,
			$settings_link
		);

		return $links;
	}

	/**
	 * Render the options page for plugin
	 *
	 * @since    1.0.0
	 */
	public function impact_measurement_page_admin() {

		include_once 'partials/impact-measurement-admin-display.php';

	}

	/**
	 * Check status after save settings.
	 */
	public function impact_measurement_config( $new_value, $old_value ) {

		$content = file_get_contents(IMPACT_MEASUREMENT_API.$new_value['code']);
		$response = json_decode($content, true);

		if ( $response && count($response['objects']) > 0 ) {
			$new_value['status'] = true;
		} else {
			$new_value['status'] = false;
		}

		return $new_value;

	}

	/**
	 * Check status after load settings page.
	 */
	public function impact_measurement_check_status(){

		global $pagenow;
		
		$im_config = get_option('impact_measurement_config');

		if ( ('options-general.php' == $pagenow || 'admin.php' == $pagenow) && 'im-settings' == $_GET['page'] ) {
			$content = file_get_contents(IMPACT_MEASUREMENT_API.$im_config['code']);
			$response = json_decode($content, true);

			if ( $response && count($response['objects']) > 0 ) {
				$im_config['status'] = true;
			} else {
				$im_config['status'] = false;
			}

			update_option('impact_measurement_config', $im_config);
		}

	}

}
