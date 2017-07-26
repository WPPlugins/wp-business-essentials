<?php

/**
 * Fired during plugin activation
 *
 * @link       https://wp-styles.de
 * @since      0.1.0
 *
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Wp_Business_Essentials_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    0.1.0
	 */
	public static function activate() {
		$class_name = 'Wp_Business_Essentials_Post_Types';
		add_action( 'init', array( $class_name, 'register_team_member' ), 1 );
		do_action( 'init' );

		flush_rewrite_rules( true );
	}

}
