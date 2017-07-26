<?php

/**
 * Provides a public-facing view for wpbe_team and wpbe_team_members
 *
 * This file is used to markup the public-facing aspects of the plugin.
 *
 * @link       https://wp-styles.de
 * @since      0.1.0
 *
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/public/partials
 */

if ( ! function_exists( 'wpbe_team' ) ) {
	/**
	 *
	 * @since 0.1.0
	 *
	 * @param integer $team_id
	 * @param array $args
	 *
	 * @return string
	 */
	function wpbe_team( $team_id, $args = array( 'columns' => 4, 'size' => 'medium' ) ) {
		$team = get_posts(
			array(
				'showposts' => - 1,
				'post_type' => 'wpbe_team_member',
				'orderby'   => 'menu_order',
				'order'     => 'ASC',
				'tax_query' => array(
					array(
						'taxonomy' => 'wpbe_team',
						'fields'   => 'term_id',
						'terms'    => $team_id
					)
				)
			)
		);

		$html = '';
		$html .= '<div class="wpbe-items">';

		foreach ( $team as $team_member ) {
			$html .= sprintf( '<div class="wpbe-item wpbe-columns-%s">%s</div>',
				$args['columns'],
				wpbe_team_member( $team_member, $args )
			);
		}

		$html .= '</div>';

		return $html;
	}
}

if ( ! function_exists( 'wpbe_team_member' ) ) {
	/**
	 *
	 * @since 0.1.0
	 *
	 * @param int|WP_Post|null $post
	 * @param array $args
	 *
	 * @return string
	 */
	function wpbe_team_member( $post, $args = array() ) {
		$post          = get_post( $post );
		$team_member   = new Wp_Business_Essentials\Markup\Team_Member( $post );
		$post_type     = 'wpbe_team_member';
		$is_post_valid = $team_member->validate_post( $post, $post_type );

		if ( true !== $is_post_valid ) {
			return $is_post_valid;
		}

		$phone     = $team_member->get_the_phone();
		$edit_link = $team_member->get_the_edit_link( $post );

		ob_start();
		?>
		<div class="wpbe-team-member" itemscope itemtype="http://schema.org/Person">

			<div class="wpbe-image-wrapper wpbe-effect-zoom">
				<?php
				echo wpbe_get_the_post_thumbnail(
					$post->ID,
					$args['size'],
					array( 'class' => 'wpbe-image' )
				);
				?>
			</div><!-- .wpbe-image-wrapper -->

			<div class="wpbe-header">
				<div class="wpbe-title wpbe-row" itemprop="name">
					<?php echo $post->post_title; ?>
				</div>
				<?php echo $team_member->get_position( array( 'class' => 'wpbe-row' ) ); ?>
			</div><!-- .wpbe-header -->

			<div class="wpbe-content">
				<?php if ( ! empty( $phone ) ) : ?>
					<div class="wpbe-row">
						<?php echo __( 'Phone', 'wp-business-essentials' ) . ': ' . $phone; ?>
					</div>
				<?php endif; ?>

				<?php
				// @todo: Add Fax
				echo $team_member->get_the_email( array( 'class' => 'wpbe-row' ) );
				echo $team_member->get_the_url( array( 'class' => 'wpbe-row' ) );
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