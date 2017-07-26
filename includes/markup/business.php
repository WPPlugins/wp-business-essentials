<?php
namespace Wp_Business_Essentials\Markup;

/**
 * wpbe_business Markup
 *
 * @since      0.2.0
 * @package    Wp_Business_Essentials
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Business extends Post_Type {

	/**
	 * Set fields.
	 *
	 * @since   0.2.0
	 */
	protected function set_fields() {
		$this->fields = array(
			'post_thumbnail' => array(
				'id'       => 'wpbe-business-image',
				'class'    => 'wpbe-image',
				'label'    => __( 'Image', 'wp-business-essentials' ),
				'itemprop' => 'image'
			),
			'post_title' => array(
				'id'       => 'wpbe-business-title',
				'class'    => 'wpbe-title',
				'label'    => __( 'Title', 'wp-business-essentials' ),
				'itemprop' => 'text'
			),
			'address'        => array(
				'id'       => 'wpbe-business-address',
				'type'     => 'text',
				'label'    => __( 'Street Address', 'wp-business-essentials' ),
				'class'    => 'wpbe-address',
				'itemprop' => 'streetAddress'
			),
			'city'           => array(
				'id'       => 'wpbe-business-city',
				'type'     => 'text',
				'label'    => __( 'City', 'wp-business-essentials' ),
				'class'    => 'wpbe-city',
				'itemprop' => 'postalCode'
			),
			'zip'            => array(
				'id'       => 'wpbe-business-zip',
				'type'     => 'text',
				'label'    => __( 'Postal code', 'wp-business-essentials' ),
				'class'    => 'wpbe-zip',
				'itemprop' => 'postalCode'
			),
			'country'        => array(
				'id'       => 'wpbe-business-country',
				'type'     => 'text',
				'label'    => __( 'Country', 'wp-business-essentials' ),
				'class'    => 'wpbe-country',
				'itemprop' => 'addressCountry'
			),
			'phone'          => array(
				'id'       => 'wpbe-business-phone',
				'type'     => 'phone',
				'label'    => __( 'Phone', 'wp-business-essentials' ),
				'class'    => 'wpbe-phone',
				'itemprop' => 'telephone'
			),
			'email'          => array(
				'id'       => 'wpbe-business-email',
				'type'     => 'email',
				'label'    => __( 'E-Mail', 'wp-business-essentials' ),
				'class'    => 'wpbe-email',
				'itemprop' => 'email'
			),
			'url'            => array(
				'id'       => 'wpbe-business-url',
				'type'     => 'url',
				'label'    => __( 'Website', 'wp-business-essentials' ),
				'class'    => 'wpbe-url',
				'itemprop' => 'url'
			),
		);
	}

}