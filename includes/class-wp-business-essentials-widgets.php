<?php

/**
 * The widgtes
 *
 * This class defines all widgets.
 *
 * @since      0.3.0
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Wp_Business_Essentials_Widget_Business extends WP_Widget {

	/**
	 * @since 0.3.0
	 * @var array
	 * @access protected
	 */
	protected $business;

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'wpbe_business',
			esc_html__( 'Business Address', 'wp-business-essentials' ),
			array( 'description' => esc_html__( 'Business Essentials - Add your business address to your sidebar.', 'wp-business-essentials' ) )
		);

		$this->business = new \Wp_Business_Essentials\Markup\Business();
	}

	/**
	 * Register Widget
	 *
	 * @since 0.3.0
	 */
	public function register() {
		register_widget( 'Wp_Business_Essentials_Widget_Business' );
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 * @since 0.3.0
	 *
	 * @param array $args Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget( $args, $instance ) {
		echo $args['before_widget'];

		if ( ! empty( $instance ) ) {
			if ( isset( $instance['wpbe_id'] ) && ! empty( $instance['wpbe_id'] ) ) {
				$business_args = array();

				foreach ( $instance as $field_id => $field ) {
					if ( 1 == $field ) {
						$business_args['display'][] = $field_id;
					}
				}

				echo \wpbe_business( $instance['wpbe_id'], $business_args );
			}
		}

		echo $args['after_widget'];
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 * @since 0.3.0
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$business_id     = ! empty( $instance['wpbe_id'] ) ? $instance['wpbe_id'] : 0;
		$business_fields = $this->business->get_fields();
		?>
		<p>
		<label for="<?php echo esc_attr( $this->get_field_id( 'wpbe_id' ) ); ?>">
			<?php esc_attr_e( 'Select business:', 'wp-business-essentials' ); ?>
		</label>
		<?php
		$args      = array(
			'post_type'      => 'wpbe_business',
			'posts_per_page' => - 1,
			'orderby'        => 'title',
			'order'          => 'ASC'
		);
		$the_query = new WP_Query( $args );

		if ( $the_query->have_posts() ) : ?>
			<select class="widefat"
			        id="<?php echo esc_attr( $this->get_field_id( 'wpbe_id' ) ); ?>"
			        name="<?php echo esc_attr( $this->get_field_name( 'wpbe_id' ) ); ?>">
				<?php
				while ( $the_query->have_posts() ) : $the_query->the_post();
					printf(
						'<option value="%s" %s>%s</option>',
						get_the_id(),
						selected( get_the_id(), $business_id ),
						get_the_title()
					);
				endwhile;
				?>
			</select>
			<?php wp_reset_postdata(); ?>
		<?php else : ?>
			<p><?php _e( 'Sorry, no business matched your criteria.', 'wp-business-essentials' ); ?></p>
		<?php endif; ?>
		</p>

		<?php if ( ! empty( $business_fields ) ) : ?>
			<p><?php esc_attr_e( 'Fields to display:', 'wp-business-essentials' ); ?></p>

			<ol style="list-style: none; -webkit-margin-start: 0; -moz-margin-start: 0;">
				<?php foreach ( $business_fields as $field ) : ?>
					<?php
					$old_instance_value = isset( $instance[ $field['id'] ] ) ? $instance[ $field['id'] ] : 1;
					?>
					<li>
						<input type="checkbox"
						       id="<?php echo esc_attr( $field['id'] ); ?>"
						       name="<?php echo esc_attr( $this->get_field_name( $field['id'] ) ); ?>"
						       value="1" <?php checked( $old_instance_value, 1 ); ?>>
						<label for="<?php echo esc_attr( $this->get_field_name( $field['id'] ) ); ?>">
							<?php esc_attr_e( $field['label'] ); ?>
						</label>
					</li>
				<?php endforeach; ?>
			</ol>
		<?php else : ?>
			<p><?php _e( 'Sorry, no fields were found.', 'wp-business-essentials' ); ?></p>
		<?php endif; ?>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 * @since 0.3.0
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance            = array();
		$instance['wpbe_id'] = ( ! empty( $new_instance['wpbe_id'] ) ) ? strip_tags( $new_instance['wpbe_id'] ) : '';
		$business_fields     = $this->business->get_fields();

		foreach ( $business_fields as $field ) {
			$instance[ $field['id'] ] = ( ! empty( $new_instance[ $field['id'] ] ) ) ? strip_tags( $new_instance[ $field['id'] ] ) : 0;
		}

		return $instance;
	}

}