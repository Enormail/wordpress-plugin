<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://enormail.eu
 * @since             1.0.0
 * @package           Enormail
 *
 * @wordpress-plugin
 * Plugin Name:       Official Enormail plugin
 * Plugin URI:        https://enormail.eu
 * Description:       The official Enormail plugin for Wordpress allows you to quickly and easily embed your signup forms on your website and grow your list.
 * Version:           1.0.0
 * Author:            Enormail
 * Author URI:        https://enormail.eu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       enormail
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define plugin path
define( 'ENORMAIL_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );

// Define plugin url
define( 'ENORMAIL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

// Define embed script url
define( 'ENORMAIL_EMBED_URL', 'https://embed.enormail.eu/js/' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-enormail-activator.php
 */
function activate_enormail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-enormail-activator.php';
	Enormail_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-enormail-deactivator.php
 */
function deactivate_enormail() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-enormail-deactivator.php';
	Enormail_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_enormail' );
register_deactivation_hook( __FILE__, 'deactivate_enormail' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-enormail.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_enormail() {

    $plugin = new Enormail();
	$plugin->run();

}
run_enormail();