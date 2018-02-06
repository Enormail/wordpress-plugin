<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://enormail.eu
 * @since      1.0.0
 *
 * @package    Enormail
 * @subpackage Enormail/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Enormail
 * @subpackage Enormail/includes
 * @author     Enormail <info@enormail.eu>
 */
class Enormail_Widget_Loader {


    /**
     * Registers the Enormail widget.
     *
     * @since    1.0.0
     */
    public function load_widget() {

        register_widget( 'Enormail_Widget' );

    }



}