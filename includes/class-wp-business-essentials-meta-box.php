<?php

/**
 * The Meta Box generator
 *
 * This class defines all fields for the custom post type wpbe_team_member.
 *
 * Initially generated by the WordPress Meta Box Generator at http://goo.gl/8nwllb
 *
 * @since     0.2.0
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Wp_Business_Essentials_Meta_Box {
	protected $screens = array();
	protected $fields = array();

	/**
	 * Class construct method. Adds actions to their respective WordPress hooks.
	 *
	 * @since   0.2.0
	 */
	public function __construct() {
		$this->set_fields();
		add_action( 'add_meta_boxes', array( $this, 'add_meta_boxes' ) );
		add_action( 'admin_footer', array( $this, 'admin_footer' ) );
		add_action( 'save_post', array( $this, 'save_post' ) );
	}

	/**
	 * Set fields.
	 *
	 * Outsoured from private property above to enable text domains.
	 *
	 * @since   0.2.0
	 */
	protected function set_fields() {
	}

	/**
	 * Hooks into WordPress' add_meta_boxes function.
	 *
	 * Goes through screens (post types) and adds the meta box.
	 *
	 * @since   0.2.0
	 */
	public function add_meta_boxes() {
	}

	/**
	 * Generates the HTML for the meta box
	 *
	 * @param object $post WordPress post object
	 *
	 * @since   0.2.0
	 */
	public function add_meta_box_callback( $post ) {
		wp_nonce_field( 'meta_box_data', 'meta_box_nonce' );
		_e( 'Socializing is an important part of building good relationships. Let your visitors know how they can reach you best.', 'wp-business-essentials' );
		$this->generate_fields( $post );
	}

	/**
	 * Hooks into WordPress' admin_footer function.
	 *
	 * Adds scripts for media uploader.
	 *
	 * @since   0.2.0
	 */
	public function admin_footer() {
		?>
		<script>
			// https://codestag.com/how-to-use-wordpress-3-5-media-uploader-in-theme-options/
			jQuery(document).ready(function ($) {
				if (typeof wp.media !== 'undefined') {
					var _custom_media = true,
						_orig_send_attachment = wp.media.editor.send.attachment;
					$('.rational-metabox-media').click(function (e) {
						var send_attachment_bkp = wp.media.editor.send.attachment;
						var button = $(this);
						var id = button.attr('id').replace('_button', '');
						_custom_media = true;
						wp.media.editor.send.attachment = function (props, attachment) {
							if (_custom_media) {
								$("#" + id).val(attachment.url);
							} else {
								return _orig_send_attachment.apply(this, [props, attachment]);
							}
						}
						wp.media.editor.open(button);
						return false;
					});
					$('.add_media').on('click', function () {
						_custom_media = false;
					});
				}
			});
		</script><?php
	}

	/**
	 * Generates the field's HTML for the meta box.
	 *
	 * @since   0.2.0
	 *
	 * @param $post
	 */
	public function generate_fields( $post ) {
		$output = '';
		foreach ( $this->fields as $field ) {
			$label    = '<label for="' . $field['id'] . '">' . $field['label'] . '</label>';
			$db_value = get_post_meta( $post->ID, $field['id'], true );
			switch ( $field['type'] ) {
				case 'checkbox':
					$input = sprintf(
						'<input %s id="%s" name="%s" type="checkbox" value="1">',
						$db_value === '1' ? 'checked' : '',
						$field['id'],
						$field['id']
					);
					break;
				case 'media':
					$input = sprintf(
						'<input class="regular-text" id="%s" name="%s" type="text" value="%s"> <input class="button rational-metabox-media" id="%s_button" name="%s_button" type="button" value="Upload" />',
						$field['id'],
						$field['id'],
						$db_value,
						$field['id'],
						$field['id']
					);
					break;
				case 'radio':
					$input = '<fieldset>';
					$input .= '<legend class="screen-reader-text">' . $field['label'] . '</legend>';
					$i = 0;
					foreach ( $field['options'] as $key => $value ) {
						$field_value = ! is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<label><input %s id="%s" name="%s" type="radio" value="%s"> %s</label>%s',
							$db_value === $field_value ? 'checked' : '',
							$field['id'],
							$field['id'],
							$field_value,
							$value,
							$i < count( $field['options'] ) - 1 ? '<br>' : ''
						);
						$i ++;
					}
					$input .= '</fieldset>';
					break;
				case 'select':
					$input = sprintf(
						'<select id="%s" name="%s">',
						$field['id'],
						$field['id']
					);
					foreach ( $field['options'] as $key => $value ) {
						$field_value = ! is_numeric( $key ) ? $key : $value;
						$input .= sprintf(
							'<option %s value="%s">%s</option>',
							$db_value === $field_value ? 'selected' : '',
							$field_value,
							$value
						);
					}
					$input .= '</select>';
					break;
				case 'textarea':
					$input = sprintf(
						'<textarea class="regular-text" id="%s" name="%s" rows="5">%s</textarea>',
						$field['id'],
						$field['id'],
						$db_value
					);
					break;
				default:
					$input = sprintf(
						'<input %s id="%s" name="%s" type="%s" value="%s">',
						$field['type'] !== 'color' ? 'class="regular-text"' : '',
						$field['id'],
						$field['id'],
						$field['type'],
						$db_value
					);
			}
			$output .= $this->row_format( $label, $input );
		}
		echo '<table class="form-table"><tbody>' . $output . '</tbody></table>';
	}

	/**
	 * Generates the HTML for table rows.
	 *
	 * @since   0.2.0
	 *
	 * @param $label
	 * @param $input
	 *
	 * @return string
	 */
	public function row_format( $label, $input ) {
		return sprintf(
			'<tr><th scope="row">%s</th><td>%s</td></tr>',
			$label,
			$input
		);
	}

	/**
	 * Hooks into WordPress' save_post function
	 *
	 * @since   0.2.0
	 *
	 * @param $post_id
	 *
	 * @return mixed
	 */
	public function save_post( $post_id ) {
		if ( ! isset( $_POST['meta_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['meta_box_nonce'];
		if ( ! wp_verify_nonce( $nonce, 'meta_box_data' ) ) {
			return $post_id;
		}

		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		foreach ( $this->fields as $field ) {
			if ( isset( $_POST[ $field['id'] ] ) ) {
				switch ( $field['type'] ) {
					case 'email':
						$_POST[ $field['id'] ] = sanitize_email( $_POST[ $field['id'] ] );
						break;
					case 'text':
						$_POST[ $field['id'] ] = sanitize_text_field( $_POST[ $field['id'] ] );
						break;
				}
				update_post_meta( $post_id, $field['id'], $_POST[ $field['id'] ] );
			} else if ( $field['type'] === 'checkbox' ) {
				update_post_meta( $post_id, $field['id'], '0' );
			}
		}
	}
}
