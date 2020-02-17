<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://reddes.bvsalud.org/
 * @since             1.0.0
 * @package           Impact_Measurement
 *
 * @wordpress-plugin
 * Plugin Name:       Impact Measurement
 * Plugin URI:        https://github.com/bireme/impact-measurement-wp-plugin/
 * Description:       This is a short description of what the plugin does. It's displayed in the WordPress admin area.
 * Version:           1.0.0
 * Author:            BIREME/OPAS/OMS
 * Author URI:        http://reddes.bvsalud.org/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       impact-measurement
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
define( 'IMPACT_MEASUREMENT_VERSION', '1.0.0' );
define( 'IMPACT_MEASUREMENT_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'IMPACT_MEASUREMENT_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
defined('IMPACT_MEASUREMENT_API') or define('IMPACT_MEASUREMENT_API', 'http://im.teste.bireme.org/api/main/?format=json&code=');
defined('IMPACT_MEASUREMENT_COOKIE_DOMAIN_SCOPE') or define('IMPACT_MEASUREMENT_COOKIE_DOMAIN_SCOPE', '/');
defined('IMPACT_MEASUREMENT_BVS_COOKIE_DOMAIN') or define('IMPACT_MEASUREMENT_BVS_COOKIE_DOMAIN', '');
defined('IMPACT_MEASUREMENT_BVSALUD_COOKIE_DOMAIN') or define('IMPACT_MEASUREMENT_BVSALUD_COOKIE_DOMAIN', '');
defined('IMPACT_MEASUREMENT_BIREME_COOKIE_DOMAIN') or define('IMPACT_MEASUREMENT_BIREME_COOKIE_DOMAIN', '');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-impact-measurement-activator.php
 */
function activate_impact_measurement() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-impact-measurement-activator.php';
	Impact_Measurement_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-impact-measurement-deactivator.php
 */
function deactivate_impact_measurement() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-impact-measurement-deactivator.php';
	Impact_Measurement_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_impact_measurement' );
register_deactivation_hook( __FILE__, 'deactivate_impact_measurement' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-impact-measurement.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_impact_measurement() {

	$plugin = new Impact_Measurement();
	$plugin->run();

}

run_impact_measurement();
