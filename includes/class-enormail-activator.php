<?php

/**
 * Fired during plugin activation
 *
 * @link       https://enormail.eu
 * @since      1.0.0
 *
 * @package    Enormail
 * @subpackage Enormail/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Enormail
 * @subpackage Enormail/includes
 * @author     Enormail <info@enormail.eu>
 */
class Enormail_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
        global $wpdb;

        $message = '';

        if ( ! function_exists('curl_version') ) {
            $message = '<p> The <strong>Enormail</strong> plugin requires <strong>php-curl</strong> library. Please visit <a target="_blank" href="http://php.net/curl">php.net/curl</a></p>';
        }

        $table_name = $wpdb->base_prefix . "enormail_forms";

        $charset_collate = ' CHARACTER SET utf8 COLLATE utf8_bin';

        $sql = "CREATE TABLE IF NOT EXISTS " . $table_name . " (
              id MEDIUMINT(9) NOT NULL AUTO_INCREMENT,
              formid VARCHAR(64) NOT NULL,
              active TINYINT(1) DEFAULT 1,
              name tinytext NOT NULL,
              data text NOT NULL,
              created_at datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
              PRIMARY KEY (id),
              UNIQUE KEY (formid),
              KEY (active)
           ) DEFAULT ".$charset_collate. ";";

        $wpdb->query($sql);
	}

}
