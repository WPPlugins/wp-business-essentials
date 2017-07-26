<?php
namespace Wp_Business_Essentials\Markup;

/**
 * wpbe_team_member Markup
 *
 * @since      0.2.0
 * @package    Wp_Business_Essentials
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Team_Member extends Post_Type {

	/**
	 * Set fields.
	 *
	 * @since   0.2.0
	 */
	protected function set_fields() {
		$this->fields = array(
			'post_thumbnail' => array(
				'class'    => 'wpbe-image',
				'itemprop' => 'image'
			),
			'position'       => array(
				'id'       => 'wpbe-team-member-position',
				'type'     => 'text',
				'label'    => __( 'Position', 'wp-business-essentials' ),
				'class'    => 'wpbe-position',
				'itemprop' => 'jobTitle',
			),
			'phone'          => array(
				'id'       => 'wpbe-team-member-phone',
				'type'     => 'phone',
				'label'    => __( 'Phone', 'wp-team-member-essentials' ),
				'class'    => 'wpbe-phone',
				'itemprop' => 'telephone'
			),
			'email'          => array(
				'id'       => 'wpbe-team-member-email',
				'type'     => 'email',
				'label'    => __( 'E-Mail', 'wp-team-member-essentials' ),
				'class'    => 'wpbe-email',
				'itemprop' => 'email'
			),
			'url'            => array(
				'id'       => 'wpbe-team-member-url',
				'type'     => 'url',
				'class'    => 'wpbe-url',
				'itemprop' => 'url'
			),
			'address'        => array(
				'id'       => 'wpbe-team-member-address',
				'type'     => 'text',
				'label'    => __( 'Street Address', 'wp-team-member-essentials' ),
				'class'    => 'wpbe-address',
				'itemprop' => ''
			)
		);
	}

	/**
	 * Get Team Member position.
	 *
	 * @since   0.2.0
	 *
	 * @param array $attr
	 *
	 * @return string
	 */
	public function get_position( array $attr = array() ) {
		$field = $this->fields['position'];

		return $this->get_the_meta_value( $field, $attr );
	}

}