<?php

/**
 * Provides a public-facing view for wpbe_business
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wp-styles.de
 * @since      0.2.0
 *
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/public/partials
 */

if ( ! function_exists( 'wpbe_business' ) ) {


	/**
	 *
	 * @since   0.2.0
	 *
	 * @param int|WP_Post|null $post
	 * @param array $args
	 *    $args = [
	 *      'container_class' => (string) Class that is applied to the container.
	 *      'display'         => (array)  Fields to display.
	 *    ]
	 *
	 * @return bool|string
	 */
	function wpbe_business( $post, $args = array() ) {
		$post          = get_post( $post );
		$business      = new Wp_Business_Essentials\Markup\Business( $post, $args );
		$post_type     = 'wpbe_business';
		$is_post_valid = $business->validate_post( $post, $post_type );

		if ( true !== $is_post_valid ) {
			return $is_post_valid;
		}

		$container_class = ( isset( $args['container_class'] ) ) ? $args['container_class'] : null;
		$phone           = $business->get_the_phone();
		$edit_link       = $business->get_the_edit_link( $post );

		ob_start();
		?>
		<div class="wpbe-business <?php echo $container_class; ?>" itemscope itemtype="http://schema.org/LocalBusiness">

			<?php if ( ! isset( $args['display'] ) || ( isset( $args['display'] ) && in_array( 'wpbe-business-image', $args['display'] ) ) ) : ?>
				<div class="wpbe-image-wrapper">
					<?php
					echo wpbe_get_the_post_thumbnail(
						$post->ID,
						'medium',
						array( 'class' => 'wpbe-image' )
					);
					?>
				</div><!-- .wpbe-image-wrapper -->
			<?php endif; ?>

			<?php if ( ! isset( $args['display'] ) || ( isset( $args['display'] ) && in_array( 'wpbe-business-title', $args['display'] ) ) ) : ?>
				<div class="wpbe-header">
					<div class="wpbe-title" itemprop="name">
						<?php echo $post->post_title; ?>
					</div>
				</div><!-- .wpbe-header -->
			<?php endif; ?>

			<div class="wpbe-content">
				<div class="wpbe-block">
					<?php echo $business->get_the_address_block(); ?>
				</div>

				<?php if ( ! empty( $phone ) ) : ?>
					<div class="wpbe-row">
						<?php echo __( 'Phone', 'wp-business-essentials' ) . ': ' . $phone; ?>
					</div>
				<?php endif; ?>

				<?php
				// @todo: Add Fax
				echo $business->get_the_email( array( 'class' => 'wpbe-row' ) );
				echo $business->get_the_url( array( 'class' => 'wpbe-row' ) );
				?>
			</div><!-- .wpbe-content -->

			<?php if ( ! empty( $edit_link ) ) : ?>
				<div class="wpbe-footer">
					<?php echo $edit_link; ?>
				</div><!-- .wpbe-footer -->
			<?php endif; ?>

		</div><!-- .wpbe-team-member -->
		<?php
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}
}