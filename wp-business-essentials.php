<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://wp-styles.de
 * @since             0.1.0
 * @package           Wp_Business_Essentials
 *
 * @wordpress-plugin
 * Plugin Name:       WP Business Essentials
 * Plugin URI:        https://github.com/mkronenfeld/WP-Business-Essentials
 * Description:       Manage your contact details and team members from your WordPress Backend.
 * Version:           0.3
 * Author:            Marvin Kronenfeld (WP-Styles.de)
 * Author URI:        https://wp-styles.de
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       wp-business-essentials
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-wp-business-essentials-activator.php
 */
function activate_wp_business_essentials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-business-essentials-activator.php';
	Wp_Business_Essentials_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-wp-business-essentials-deactivator.php
 */
function deactivate_wp_business_essentials() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-business-essentials-deactivator.php';
	Wp_Business_Essentials_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_wp_business_essentials' );
register_deactivation_hook( __FILE__, 'deactivate_wp_business_essentials' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-wp-business-essentials.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    0.1.0
 */
function run_wp_business_essentials() {

	$plugin = new Wp_Business_Essentials();
	$plugin->run();

}

run_wp_business_essentials();
