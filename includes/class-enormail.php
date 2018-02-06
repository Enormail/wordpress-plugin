<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       https://enormail.eu
 * @since      1.0.0
 *
 * @package    Enormail
 * @subpackage Enormail/includes
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
 * @since      1.0.0
 * @package    Enormail
 * @subpackage Enormail/includes
 * @author     Enormail <info@enormail.eu>
 */
class Enormail {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Enormail_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'enormail';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
        $this->load_widget();
        $this->register_shortcode();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Enormail_Loader. Orchestrates the hooks of the plugin.
	 * - Enormail_i18n. Defines internationalization functionality.
	 * - Enormail_Admin. Defines all hooks for the admin area.
	 * - Enormail_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-enormail-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-enormail-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-enormail-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-enormail-public.php';

        /**
         * The class responsible for displaying the admin form list table.
         */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-enormail-forms-list.php';

        /**
         * The class responsible for loading the Enormail widget.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-enormail-widget-loader.php';

        /**
         * The class responsible for displaying notifications.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-enormail-notifications.php';

        /**
         * The class responsible for displaying and managing the Enormail widget.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-enormail-widget.php';

        /**
         * The class responsible for displaying and managing the Enormail shortcode.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-enormail-shortcode.php';

        /**
         * The class responsible for loading the Enormail API client.
         */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/emapi/emapi.php';

		$this->loader = new Enormail_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Enormail_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Enormail_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

    /**
     * Registers the Enormail widget loader.
     *
     * Uses the Enormail_Widget_loader class to initialize and load the Enormail widget.
     *
     * @since    1.0.0
     * @access   private
     */
	private function load_widget()
    {
        $widget_loader = new Enormail_Widget_Loader();

        $this->loader->add_action( 'widgets_init', $widget_loader, 'load_widget' );
    }

    /**
     * Registers the Enormail shortcode loader.
     *
     * Uses the Enormail_Widget_loader class to initialize and load the Enormail widget.
     *
     * @since    1.0.0
     * @access   private
     */
    private function register_shortcode()
    {
        $shortcode = new Enormail_Shortcode();

        $this->loader->add_action( 'init', $shortcode, 'register' );
    }

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Enormail_Admin( $this->get_plugin_name(), $this->get_version() );

        $this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_page' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Enormail_Public( $this->get_plugin_name(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Enormail_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
