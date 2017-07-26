<?php

/**
 * Provide a public-facing view for the plugin
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wp-styles.de
 * @since      0.1.0
 *
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/public/partials
 */

if ( ! function_exists( 'wpbe_get_edit_link' ) ) {
	function wpbe_get_edit_link( $post ) {
		$html         = '';
		$current_user = get_current_user_id();

		if ( user_can( $current_user, 'editor' ) || user_can( $current_user, 'administrator' ) ) {
			$html .= sprintf( '<a href="%swp-admin/post.php?post=%s&action=edit" class="wpbe-edit">%s</a>',
				esc_url( home_url( '/' ) ),
				$post->ID,
				__( 'Edit', 'wp-business-essentials' )
			);
		}

		return $html;
	}
}

if ( ! function_exists( 'wpbe_get_title' ) ) {
	function wpbe_get_title( $post, array $attr = array() ) {
		$attr['container'] = ( isset( $attr['container'] ) ) ? $attr['container'] : 'span';
		$attr['itemprop']  = ( isset( $attr['itemprop'] ) ) ? $attr['itemprop'] : 'name';

		return sprintf(
			'<%s class="wpbe-title" itemprop="%s">%s</%s>',
			$attr['container'],
			$attr['itemprop'],
			esc_html( $post->post_title ),
			$attr['container']
		);
	}
}

if ( ! function_exists( 'wpbe_get_the_post_thumbnail' ) ) {
	function wpbe_get_the_post_thumbnail( $post, $size = 'post-thumbnail', array $attr = array() ) {
		$attr['class']    = ( isset( $attr['class'] ) ) ? $attr['class'] : 'wpbe-image';
		$attr['itemprop'] = ( isset( $attr['itemprop'] ) ) ? $attr['itemprop'] : 'image';

		return get_the_post_thumbnail( $post, $size, $attr );
	}
}

require_once 'wp-business-essentials-public-display-team.php';

require_once 'wp-business-essentials-public-display-business.php';
