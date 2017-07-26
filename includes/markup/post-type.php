<?php

namespace Wp_Business_Essentials\Markup;

/**
 * Custom Post Type Markup
 *
 * @since      0.2.0
 * @package    Wp_Business_Essentials
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Post_Type {

	/**
	 * @since  0.2.0
	 * @var    WP_Post
	 * @access protected
	 */
	protected $post;

	/**
	 * @since  0.2.0
	 * @var    array
	 * @access protected
	 */
	protected $fields;

	/**
	 * @var     array
	 * @since   0.3.0
	 * @access  protected
	 */
	protected $args;

	/**
	 * Post_Type constructor.
	 *
	 * @since 0.2.0
	 *
	 * @param int|WP_Post $post Post ID or post object
	 * @param array $args Post Type arguments.
	 */
	public function __construct( $post = null, $args = array() ) {
		$this->post = $post;
		$this->args = $args;
		$this->set_fields();
	}

	/**
	 * Set fields.
	 *
	 * Outsoured from private property above to enable text domains.
	 *
	 * @since 0.2.0
	 *
	 * @access protected
	 */
	protected function set_fields() {
	}

	/**
	 * Get fields.
	 *
	 * @since 0.3.0
	 *
	 * @return array
	 */
	public function get_fields() {
		return $this->fields;
	}

	/**
	 * Get a meta value.
	 *
	 * A single meta value from a custom field.
	 *
	 * @since 0.2.0
	 *
	 * @param $id
	 * @param $key
	 *
	 * @return bool
	 */
	public function get_meta_value( $id, $key ) {
		$meta = esc_html( get_post_meta( $id, $key, true ) );
		if ( empty( $meta ) ) {
			return false;
		}

		return $meta;
	}

	/**
	 * Get the meta value.
	 *
	 * Markup for a single meta value from a custom field.
	 *
	 * @since   0.2.0
	 *
	 * @param $field
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_meta_value( $field, array $attr = array() ) {
		if ( isset( $this->args['display'] ) && ! in_array( $field['id'], $this->args['display'] ) ) {
			return false;
		}

		$meta_value = esc_html( $this->get_meta_value( $this->post->ID, $field['id'], true ) );

		if ( empty( $meta_value ) ) {
			return false;
		}

		$field['type']     = ( isset( $field['type'] ) ) ? $field['type'] : 'text';
		$field['class']    = ( isset( $attr['class'] ) ) ? $field['class'] . ' ' . $attr['class'] : $field['class'];
		$field['itemprop'] = ( isset( $attr['itemprop'] ) ) ? $attr['itemprop'] : $field['itemprop'];

		switch ( $field['type'] ) {
			case 'email':
				$html = sprintf(
					'<a href="mailto:%s" class="%s" itemprop="%s">%s</a>',
					$meta_value,
					$field['class'],
					$field['itemprop'],
					$meta_value
				);
				break;
			case 'url':
				$label = preg_replace( "(^https?://)", "", $meta_value );
				$html  = sprintf(
					'<a href="%s" class="%s" itemprop="%s">%s</a>',
					$meta_value,
					$field['class'],
					$field['itemprop'],
					$label
				);
				break;
			case 'phone':
				return sprintf(
					'<span class="%s" itemprop="%s">%s</span>',
					$field['class'],
					$field['itemprop'],
					$meta_value
				);
				break;
			default:
				if ( isset( $field['itemprop'] ) ) {
					$field['itemprop'] = sprintf(
						'itemprop="%s"',
						$field['itemprop']
					);
				} else {
					$field['itemprop'] = null;
				}

				return sprintf(
					'<span class="%s" %s>%s</span>',
					$field['class'],
					$field['itemprop'],
					$meta_value
				);
				break;
		}

		return $html;
	}

	/**
	 * Validate the Post.
	 *
	 * @since 0.2.0
	 *
	 * @param $post
	 * @param $post_type
	 *
	 * @return bool|string true || Error message
	 */
	public function validate_post( $post, $post_type ) {
		if ( ! $post instanceof \WP_Post || $post_type !== $post->post_type ) {
			return sprintf(
				'<div class="wpbe_error">%s %s</div>',
				__( 'Error: The ID doesn\'t work for custom post type', 'wp-business-essentials' ),
				$post_type
			);
		}

		return true;
	}

	/**
	 * Get the title.
	 *
	 * @since 0.2.0
	 *
	 * @param $post
	 * @param array $attr
	 *
	 * @return string
	 */
	public function get_the_title( $post, array $attr = array() ) {
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

	/**
	 * Get the post thumbnail.
	 *
	 * @since 0.2.0
	 *
	 * @param $post
	 * @param string $size
	 * @param array $attr
	 *
	 * @return mixed
	 */
	public function get_the_post_thumbnail( $post, $size = 'post-thumbnail', array $attr = array() ) {
		$attr['class']    = ( isset( $attr['class'] ) ) ? $attr['class'] : 'wpbe-image';
		$attr['itemprop'] = ( isset( $attr['itemprop'] ) ) ? $attr['itemprop'] : 'image';

		return get_the_post_thumbnail( $post, $size, $attr );
	}

	/**
	 * Get phone / mobile.
	 *
	 * @since 0.2.0
	 *
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_phone( array $attr = array() ) {
		$field = $this->fields['phone'];

		return $this->get_the_meta_value( $field, $attr );
	}

	/**
	 * Get E-Mail.
	 *
	 * @since 0.2.0
	 *
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_email( array $attr = array() ) {
		$field = $this->fields['email'];

		return $this->get_the_meta_value( $field, $attr );
	}

	/**
	 * Get url.
	 *
	 * @since 0.2.0
	 *
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_url( array $attr = array() ) {
		$field = $this->fields['url'];

		return $this->get_the_meta_value( $field, $attr );
	}

	/**
	 * Get street address.
	 *
	 * @since 0.2.0
	 *
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_address( array $attr = array() ) {
		$field = $this->fields['address'];

		return $this->get_the_meta_value( $field, $attr );
	}

	/**
	 * Get city.
	 *
	 * @since 0.2.0
	 *
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_city( array $attr = array() ) {
		$field = $this->fields['city'];

		return $this->get_the_meta_value( $field, $attr );
	}

	/**
	 * Get country.
	 *
	 * @since 0.2.0
	 *
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_country( array $attr = array() ) {
		$field = $this->fields['country'];

		return $this->get_the_meta_value( $field, $attr );
	}

	/**
	 * Get zip / postal code.
	 *
	 * @since 0.2.0
	 *
	 * @param array $attr
	 *
	 * @return bool|string
	 */
	public function get_the_zip( array $attr = array() ) {
		$field = $this->fields['zip'];

		return $this->get_the_meta_value( $field, $attr );
	}

	/**
	 * Get an address block.
	 *
	 * @todo Move markup code to /public/partials
	 *
	 * @since 0.2.0
	 *
	 * @return string
	 */
	public function get_the_address_block() {
		ob_start();
		?>
		<div itemprop="address" itemscope itemtype="schema.org/PostalAddress">
			<div class="wpbe-row"><?php echo $this->get_the_address( array( 'class' => 'wpbe-row' ) ); ?></div>
			<div class="wpbe-row"><?php echo $this->get_the_zip() . ' ' . $this->get_the_city(); ?></div>
			<div class="wpbe-row"><?php echo $this->get_the_country( array( 'class' => 'wpbe-row' ) ); ?></div>
		</div>
		<?php
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	/**
	 * Get an post edit link.
	 *
	 * @since 0.2.0
	 *
	 * @return string
	 */
	public function get_the_edit_link() {
		$html         = '';
		$current_user = get_current_user_id();

		if ( user_can( $current_user, 'editor' ) || user_can( $current_user, 'administrator' ) ) {
			$html .= sprintf( '<a href="%swp-admin/post.php?post=%s&action=edit" class="wpbe-edit">%s</a>',
				esc_url( home_url( '/' ) ),
				$this->post->ID,
				__( 'Edit', 'wp-business-essentials' )
			);
		}

		return $html;
	}

}