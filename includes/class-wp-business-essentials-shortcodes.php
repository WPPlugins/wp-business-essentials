<?php

/**
 * Shortcode collection
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      0.1.0
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Wp_Business_Essentials_Shortcodes {

	/**
	 * Adds Team shortcode
	 *
	 * @since      0.1.0
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public static function add_shortcode_team( $atts ) {
		$atts = shortcode_atts(
			array(
				'id'      => '0',
				'columns' => 4,
				'size'    => 'medium'
			),
			$atts
		);

		return \wpbe_team( $atts['id'], array(
			'columns' => $atts['columns'],
			'size'    => $atts['size']
		) );
	}

	/**
	 * Adds Business shortcode
	 *
	 * @since      0.2.0
	 *
	 * @param array $atts
	 *
	 * @return string
	 */
	public static function add_shortcode_business( $atts ) {
		$atts = shortcode_atts(
			array(
				'id'              => '0',
				'container_class' => null
			),
			$atts
		);

		return \wpbe_business( $atts['id'], array(
			'container_class' => $atts['container_class']
		) );
	}

}