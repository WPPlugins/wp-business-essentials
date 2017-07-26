<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://wp-styles.de
 * @since      0.1.0
 *
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      0.1.0
 * @package    Wp_Business_Essentials
 * @subpackage Wp_Business_Essentials/includes
 * @author     Marvin Kronenfeld (WP-Styles.de) <hello@wp-styles.de>
 */
class Wp_Business_Essentials {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      Wp_Business_Essentials_Loader $loader Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string $plugin_name The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    0.1.0
	 * @access   protected
	 * @var      string $version The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    0.1.0
	 */
	public function __construct() {

		$this->plugin_name = 'wp-business-essentials';
		$this->version     = '0.3';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Wp_Business_Essentials_Loader. Orchestrates the hooks of the plugin.
	 * - Wp_Business_Essentials_i18n. Defines internationalization functionality.
	 * - Wp_Business_Essentials_Admin. Defines all hooks for the admin area.
	 * - Wp_Business_Essentials_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function load_dependencies() {

		$plugin_dir_path = plugin_dir_path( dirname( __FILE__ ) );

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once $plugin_dir_path . 'includes/class-wp-business-essentials-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once $plugin_dir_path . 'includes/class-wp-business-essentials-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once $plugin_dir_path . 'admin/class-wp-business-essentials-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once $plugin_dir_path . 'public/class-wp-business-essentials-public.php';


		require_once $plugin_dir_path . 'includes/class-wp-business-essentials-post-types.php';

		require_once $plugin_dir_path . 'includes/markup/post-type.php';
		require_once $plugin_dir_path . 'includes/markup/business.php';
		require_once $plugin_dir_path . 'includes/markup/team-member.php';

		require_once $plugin_dir_path . 'includes/class-wp-business-essentials-meta-box.php';
		require_once $plugin_dir_path . 'includes/class-wp-business-essentials-meta-box-business.php';
		require_once $plugin_dir_path . 'includes/class-wp-business-essentials-meta-box-team-member.php';

		require_once $plugin_dir_path . 'includes/class-wp-business-essentials-widgets.php';

		if ( ! is_admin() ) {
			require_once $plugin_dir_path . 'includes/class-wp-business-essentials-shortcodes.php';
			require_once $plugin_dir_path . 'public/partials/wp-business-essentials-public.php';
		}

		$this->loader = new Wp_Business_Essentials_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Wp_Business_Essentials_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Wp_Business_Essentials_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		//$plugin_admin = new Wp_Business_Essentials_Admin( $this->get_plugin_name(), $this->get_version() );
		$post_types = new Wp_Business_Essentials_Post_Types();
		$widgets    = new Wp_Business_Essentials_Widget_Business();
		new Wp_Business_Essentials_Meta_Box_Business();
		new Wp_Business_Essentials_Meta_Box_Team_Member();

		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		//$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'init', $post_types, 'register_business' );
		$this->loader->add_action( 'init', $post_types, 'register_team_member' );
		$this->loader->add_action( 'init', $post_types, 'register_team' );
		$this->loader->add_action( 'widgets_init', $widgets, 'register' );
	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    0.1.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Wp_Business_Essentials_Public( $this->get_plugin_name(), $this->get_version() );
		// $post_types    = new Wp_Business_Essentials_Post_Types();

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		if ( ! is_admin() ) {
			$shortcode = new Wp_Business_Essentials_Shortcodes();
			$this->loader->add_shortcode( 'wpbe_team', $shortcode, 'add_shortcode_team' );
			$this->loader->add_shortcode( 'wpbe_business', $shortcode, 'add_shortcode_business' );
		}

		// Custom post template for single team members. Still some todos.
		$this->loader->add_filter( 'single_template', $this->loader, 'register_single_template_team_member' );

		// add_shortcode( 'wpbe_team_member', 'shortcode_team_member' );
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    0.1.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     0.1.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     0.1.0
	 * @return    Wp_Business_Essentials_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     0.1.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
