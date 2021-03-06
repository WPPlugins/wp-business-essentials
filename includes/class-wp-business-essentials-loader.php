<?php

/**
 * Register all actions and filters for the plugin
 *
 * @link       https://wp-styles.de
 * @since      0.1.0
 *
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 */

/**
 * Register all actions and filters for the plugin.
 *
 * Maintain a list of all hooks that are registered throughout
 * the plugin, and register them with the WordPress API. Call the
 * run function to execute the list of actions and filters.
 *
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Wp_Business_Essentials_Loader {

	/**
	 * The array of actions registered with WordPress.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      array $actions The actions registered with WordPress to fire when the plugin loads.
	 */
	protected $actions;

	/**
	 * The array of filters registered with WordPress.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      array $filters The filters registered with WordPress to fire when the plugin loads.
	 */
	protected $filters;

	/**
	 * The array of shortcodes registered with WordPress.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      array $shortcodes The shortcodes registered with WordPress to fire when the plugin loads.
	 */
	protected $shortcodes;

	/**
	 * Initialize the collections used to maintain the actions and filters.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->actions    = array();
		$this->filters    = array();
		$this->shortcodes = array();

	}

	/**
	 * Add a new action to the collection to be registered with WordPress.
	 *
	 * @since    0.1.0
	 *
	 * @param    string $hook The name of the WordPress action that is being registered.
	 * @param    object $component A reference to the instance of the object on which the action is defined.
	 * @param    string $callback The name of the function definition on the $component.
	 * @param    int $priority Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1.
	 */
	public function add_action( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->actions = $this->add( $this->actions, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new filter to the collection to be registered with WordPress.
	 *
	 * @since    0.1.0
	 *
	 * @param    string $hook The name of the WordPress filter that is being registered.
	 * @param    object $component A reference to the instance of the object on which the filter is defined.
	 * @param    string $callback The name of the function definition on the $component.
	 * @param    int $priority Optional. he priority at which the function should be fired. Default is 10.
	 * @param    int $accepted_args Optional. The number of arguments that should be passed to the $callback. Default is 1
	 */
	public function add_filter( $hook, $component, $callback, $priority = 10, $accepted_args = 1 ) {
		$this->filters = $this->add( $this->filters, $hook, $component, $callback, $priority, $accepted_args );
	}

	/**
	 * Add a new shortcode to the collection to be registered with WordPress.
	 *
	 * @since    0.1.0
	 *
	 * @param    string $tag Shortcode tag to be searched in post content
	 * @param    object $component A reference to the instance of the object on which the filter is defined.
	 * @param    string $hook Hook to run when shortcode is found
	 */
	public function add_shortcode( $tag, $component, $hook ) {
		$this->shortcodes[] = array(
			'tag'       => $tag,
			'component' => $component,
			'hook'      => $hook
		);
	}

	/**
	 * A utility function that is used to register the actions and hooks into a single
	 * collection.
	 *
	 * @since    0.1.0
	 * @access   private
	 *
	 * @param    array $hooks The collection of hooks that is being registered (that is, actions or filters).
	 * @param    string $hook The name of the WordPress filter that is being registered.
	 * @param    object $component A reference to the instance of the object on which the filter is defined.
	 * @param    string $callback The name of the function definition on the $component.
	 * @param    int $priority The priority at which the function should be fired.
	 * @param    int $accepted_args The number of arguments that should be passed to the $callback.
	 *
	 * @return   array The collection of actions and filters registered with WordPress.
	 */
	private function add( $hooks, $hook, $component, $callback = null, $priority = null, $accepted_args = null ) {

		$hooks[] = array(
			'hook'          => $hook,
			'component'     => $component,
			'callback'      => $callback,
			'priority'      => $priority,
			'accepted_args' => $accepted_args
		);

		return $hooks;
	}

	/**
	 * Register the filters and actions with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {

		foreach ( $this->filters as $hook ) {
			add_filter( $hook['hook'], array(
				$hook['component'],
				$hook['callback']
			), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->actions as $hook ) {
			add_action( $hook['hook'], array(
				$hook['component'],
				$hook['callback']
			), $hook['priority'], $hook['accepted_args'] );
		}

		foreach ( $this->shortcodes as $hook ) {
			add_shortcode( $hook['tag'], array(
				$hook['component'],
				$hook['hook']
			) );
		}

	}


	/**
	 * Register single template for wpbe_team_member
	 *
	 * @link   https://codex.wordpress.org/Plugin_API/Filter_Reference/single_template
	 * @since  0.1.0
	 *
	 * @param  $single
	 *
	 * @return string
	 */
	function register_single_template_team_member( $single ) {
		global $post; // $wp_query

		$custom_post_type = 'wpbe_team_member';
		$single_template  = '/single-' . $custom_post_type . '.php';
		$filename_theme   = get_template_directory() . $single_template;
		$filename_plugin  = plugin_dir_path( dirname( __FILE__ ) ) . 'public/partials' . $single_template;

		if ( $custom_post_type === $post->post_type ) {
			if ( file_exists( $filename_theme ) ) {
				return $filename_theme;
			} elseif ( file_exists( $filename_plugin ) ) {
				return $filename_plugin;
			}
		}

		return $single;
	}


}
