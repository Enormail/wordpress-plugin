<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://enormail.eu
 * @since      1.0.0
 *
 * @package    Enormail
 * @subpackage Enormail/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Enormail
 * @subpackage Enormail/public
 * @author     Enormail <info@enormail.eu>
 */
class Enormail_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Fetches the embedded forms from the database and enqueues the form embed script.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		global $wpdb;

		$forms = $wpdb->get_results("SELECT formid FROM {$wpdb->prefix}enormail_forms WHERE active = 1", OBJECT);

		if ($forms) {
		    foreach ($forms as $form) {
		        wp_enqueue_script('enormail_webform_'.$form->formid, ENORMAIL_EMBED_URL.$form->formid.'.js', array(), 'v1', true);
            }
        }

	}

}
