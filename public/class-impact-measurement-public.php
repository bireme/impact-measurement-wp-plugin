<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://reddes.bvsalud.org/
 * @since      1.0.0
 *
 * @package    Impact_Measurement
 * @subpackage Impact_Measurement/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Impact_Measurement
 * @subpackage Impact_Measurement/public
 * @author     BIREME/OPAS/OMS <ofibireme@paho.org>
 */
class Impact_Measurement_Public {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/impact-measurement-public.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'bootstrap-iso', plugin_dir_url( __FILE__ ) . 'css/bootstrap-iso.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/impact-measurement-public.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'bootstrap', 'https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/js/bootstrap.min.js', array( 'jquery' ), $this->version, false );

	}

	/**
	 * Render the survey box
	 *
	 * @since    1.0.0
	 */
	public function impact_measurement_render_survey_box() {

		if ( !is_single() && !is_page() ) {
	    	include_once 'partials/impact-measurement-public-display.php';
	    }

	}

	/**
	 * Generate cookie
	 *
	 * @since    1.0.0
	 */
	public function impact_measurement_cookie() {

		global $impact_measurement_cookie;

		if ( ! $_COOKIE['impact_measurement'] ) {
			$impact_measurement_cookie = md5(uniqid(rand(), true));
			setcookie("impact_measurement", $impact_measurement_cookie, (time() + (10 * 365 * 24 * 60 * 60)), '/', IMPACT_MEASUREMENT_COOKIE_DOMAIN_SCOPE);
			add_action( 'wp_head', array(&$this, 'impact_measurement_sso_cookie') ); // SSO cookie
		}

	}

	/**
	 * Generate SSO cookie
	 *
	 * @since    1.0.0
	 */
	public function impact_measurement_sso_cookie() {

		global $impact_measurement_cookie;

		$domains = array(
			'.bvs.br' => IMPACT_MEASUREMENT_BVS_COOKIE_DOMAIN,
			'.bvsalud.org' => IMPACT_MEASUREMENT_BVSALUD_COOKIE_DOMAIN,
			'.bireme.org' => IMPACT_MEASUREMENT_BIREME_COOKIE_DOMAIN
		);

		if ( array_key_exists(IMPACT_MEASUREMENT_COOKIE_DOMAIN_SCOPE, $domains) ) {
			$im_config = get_option('impact_measurement_config');
			$im_api = base64_encode(IMPACT_MEASUREMENT_API);
			unset($domains[IMPACT_MEASUREMENT_COOKIE_DOMAIN_SCOPE]);

			foreach ($domains as $domain => $url) {
				if ( ! empty($url) ) {
					$src = $url.'/setcookie.php?im_cookie='.$impact_measurement_cookie.'&im_code='.$im_config['code'].'&im_data='.$im_api;
			        ?>
			        <script type="text/javascript">
			            var el = document.createElement("img");
			            el.setAttribute('src', "<?php echo $src; ?>");
			        </script>
			        <?php
			    }
		    }
		}

	}

	public function impact_measurement_after_post_content($content) {

	    if ( is_single() || is_page() ) {

	    	ob_start();
	    	include 'partials/impact-measurement-public-display.php';
	    	$contents = ob_get_contents();
	    	ob_end_clean();

	    	$content .= $contents;

	    }

	    return $content;

	}

}
