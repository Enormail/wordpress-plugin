<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://enormail.eu
 * @since      1.0.0
 *
 * @package    Enormail
 * @subpackage Enormail/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Enormail
 * @subpackage Enormail/admin
 * @author     Enormail <info@enormail.eu>
 */
class Enormail_Admin {

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
     * The Enormail api client.
     *
     * @since    1.0.0
     * @access   private
     * @var      object    $api     The Enormail api client.
     */
	private $api;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        $this->api = new EMAPI(get_option('enormail_api_key'), 'json');

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Enormail_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Enormail_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/enormail-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Enormail_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Enormail_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/enormail-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_admin_page() {

        add_menu_page(
	        'Enormail',
            'Enormail',
            'manage_options',
            'enormail-admin',
            null,
            'data:image/svg+xml;base64,PHN2ZyBpZD0iTGFhZ18xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIxNDciIGhlaWdodD0iNzYiIHZpZXdCb3g9Ii02NCAzODIuOSAxNDcgNzYiPjxzdHlsZT4uc3Qwe2ZpbGw6I2ZmZn08L3N0eWxlPjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik0tMjEuNSAzODNoMTIuMmM0LjQgMCA4LjgtLjIgMTMuMi4xIDUuOS4yIDExLjggMS44IDE3LjEgNC41bC01MC4yIDMzLjFjLTMuMS01LjEtNi4xLTEwLjEtOS4yLTE1LjItMi4xLTMuNC00LjEtNi44LTYuMi0xMC4ybC0xLjgtM2MtLjEtLjItLjQtLjUtLjQtLjcgMC0uNSAxLjUtMS4yIDEuOS0xLjUgNi45LTQuNiAxNS4xLTcuMSAyMy40LTcuMW0tMTkuMiAyOC44TC01MSAzOTQuOWMtNy41IDcuMi0x\Mi40IDE3LjItMTMgMjguMmwyMy4zLTExLjN6Ii8+PHBhdGggY2xhc3M9InN0MCIgZD0iTS4zIDQ0NC42aC0yNC44djE0LjNILTY0di0zMGwyNi4xLTEyLjQgNy4xIDExLjd2LS4xLjFjMi43LTEuOCA1LjMtMy41IDgtNS4zLjgtLjUgMS41LTEgMi4zLTEuNS4zLS4yLjktLjggMS4zLS45LjQtLjEuNS40LjguNyA0LjcgNS44IDkuMyAxMS43IDE0IDE3LjUgMS42IDIgMy4yIDMuOSA0LjcgNS45ek02Mi4xIDQzMWMtMS45IDMuMS00LjkgNS04LjQgNS43LTIuMi40LTQuNy43LTYuNy0uNC0uOS0uNS0xLjktMS4zLTIuMy0yLjItLjUtMS4xLS41LTIuNS0uNS0zLjd2LTQuOWMwLTkuOS0zLjYtMTkuNy0xMC0yNy4zLTEuNi0xLjktMy4zLTMuNi01LjItNS4yLS43LS42LTEuNy0xLjctMi42LTItLjYtLjIgMC0uMi0uNC0uMS0uMy4xLS43LjUtMSAuNi0uNi40LTEuMy44LTEuOSAxLjMtOS42IDYuMy0xOS4yIDEyLjctMjguOCAxOS0yLjkgMS45LTUuOSAzLjktOC44IDUuOGwyMS4xIDI3aC0uMXYxNC4zaDM3LjZ2LTYuN2MxMS41IDcgMjYuNyAzLjcgMzQuNC03LjMgNy0xMC4xIDUuNy0yNC4yLTMuMS0zMi45LTQuOC00LjctMTEuMy03LjMtMTgtNy4zVjQxN2guMWM2LjEgMCAxMS42IDQuMyAxMyAxMC4zIDEuNCA1LjktMS42IDEyLjItNyAxNC45LTMuNSAxLjctNy42IDEuOS0xMS4yLjMgNS41LTEgOS42LTUuOSA5LjgtMTEuNU0yMiA0MTguM2MtMi41IDAtNC41LTIuMS00LjUtNC41IDAtMi41IDIuMS00LjUgNC41LTQuNSAyLjUgMCA0LjUgMi4xIDQuNSA0LjVzLTIuMSA0LjUtNC41IDQuNSIvPjwvc3ZnPg=='
        );

        add_submenu_page(
            'enormail-admin',
            __( 'Forms', 'enormail' ),
            __( 'Forms', 'enormail' ),
            'manage_options',
            'enormail-admin',
            array( $this, 'init_page' )
        );

        add_submenu_page(
            'enormail-admin',
            __( 'Settings', 'enormail' ),
            __( 'Settings', 'enormail' ),
            'manage_options',
            'enormail-api-key',
            array( $this, 'display_api_key_page' )
        );

    }

    public function init_page() {

	    if ( ! $apiVerified = $this->verify_api_key( get_option( 'enormail_api_key' ) ) ) {
            $this->display_api_key_page( $apiVerified );
        } else {
            if ( isset( $_GET['view'] ) && method_exists( $this, 'display_' . sanitize_key( $_GET['view'] ) . '_page') ) {
                $page = 'display_' . sanitize_key( $_GET['view'] ) . '_page';
                $this->$page();
            } else {
                $this->display_form_list_page();
            }
        }

    }

    public function display_api_key_page( $apiVerified = true ) {

	    $redirect_url = (get_option( 'enormail_api_key' ) === false) ?
            'admin.php?page=enormail-admin&notify=apikey_updated' :
            'admin.php?page=enormail-api-key&notify=apikey_updated';

	    if ( isset( $_POST['enormail_api_key'] ) && $_POST['enormail_api_key'] != '' ) {
            $apiKey = esc_html( $_POST['enormail_api_key'] );

            if ( $apiVerified = $this->verify_api_key( $apiKey ) ) {
                update_option( 'enormail_api_key', $apiKey );

                if ( wp_redirect( admin_url($redirect_url) ) ) {
                    exit();
                }
            }
        }

        if ( isset( $_GET['noheader'] ) && $_GET['noheader'] == 'true' ) {
            require_once( ABSPATH . 'wp-admin/admin-header.php' );
        }

        require_once( __DIR__ . '/partials/enormail-admin-api-key.php' );

    }

    public function display_form_list_page() {

	    $formsTable = new Enormail_Forms_List_Table();

        require_once( __DIR__ . '/partials/enormail-admin-forms.php' );

    }

    public function display_add_form_page() {

        global $wpdb;

	    if ( isset( $_POST['enormail_formid'] ) ) {
            $formId = sanitize_key($_POST['enormail_formid']);
            $name   = $_POST['enormail_form_name'];
            $form   = $this->call_api('forms', 'details', array('formid' => $formId));

            if (! $form) {
                if ( wp_redirect( admin_url('admin.php?page=enormail-admin&view=add_form&notify=form_not_found') ) ) {
                    exit();
                }
            }

            // Check for duplicates
            if ($duplicate = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}enormail_forms WHERE formid = %s", $formId ) ) ) {
                if ( wp_redirect( admin_url('admin.php?page=enormail-admin&view=add_form&notify=form_duplicate') ) ) {
                    exit();
                }
            }

            $wpdb->insert( $wpdb->prefix . 'enormail_forms', array(
                'formid' => esc_sql($formId),
                'name' => esc_sql($name),
                'data' => json_encode($form),
                'created_at' => date('Y-m-d H:i:s')
            ) );

            if ( wp_redirect( admin_url('admin.php?page=enormail-admin&notify=form_created') ) ) {
                exit();
            }
        }

        $apiFormList = $this->get_api_form_list();

        if ( isset( $_GET['noheader'] ) && $_GET['noheader'] == 'true' ) {
            require_once( ABSPATH . 'wp-admin/admin-header.php' );
        }

        require_once( __DIR__ . '/partials/enormail-admin-add-form.php' );

    }

    public function display_edit_form_page() {

        global $wpdb;

        if ( isset( $_POST['enormail_formid'] ) ) {

            $id     = absint( $_POST['id'] );
            $formId = sanitize_key( $_POST['enormail_formid'] );
            $name   = $_POST['enormail_form_name'];
            $form   = $this->call_api( 'forms', 'details', array( 'formid' => $formId ) );

            if ( $form ) {

                $wpdb->update( $wpdb->prefix . 'enormail_forms', array(
                    'formid' => esc_sql($formId),
                    'name' => esc_sql($name),
                    'data' => json_encode($form),
                    'created_at' => date('Y-m-d H:i:s')
                ), array( 'id' => $id ) );

            }

            if (wp_redirect( admin_url( 'admin.php?page=enormail-admin&view=edit_form&id=' . $id . '&notify=form_saved' ) ) ) {
                exit();
            }

        }

        if ( ! isset( $_GET['id'] ) || ! is_numeric( $_GET['id'] ) ) {

            if (wp_redirect( admin_url( 'admin.php?page=enormail-admin' ) ) ) {
                exit();
            }

        }

        $id = absint( $_GET['id'] );

        if (! $form = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}enormail_forms WHERE id = %d", $id ) ) ) {

            if (wp_redirect( admin_url( 'admin.php?page=enormail-admin' ) ) ) {
                exit();
            }

        }

        $apiFormList = $this->get_api_form_list();

        if ( isset( $_GET['noheader'] ) && $_GET['noheader'] == 'true' ) {
            require_once( ABSPATH . 'wp-admin/admin-header.php' );
        }

        require_once( __DIR__ . '/partials/enormail-admin-edit-form.php' );

    }

    private function verify_api_key($apiKey) {

	    $client = new EMAPI($apiKey, 'json');

	    $result = json_decode($client->test(), true);

        if ( isset( $result['ping'] ) && $result['ping'] == 'hello' ) {
            return true;
        }

        return false;

    }

    private function call_api( $resource, $method, $args = array() ) {

        $result = json_decode( call_user_func_array( array( $this->api->$resource, $method) , $args ), true );

        if ( isset( $result['error'] ) ) {
            return false;
        }

        return $result;

    }

    private function get_api_form_list() {

        $apiFormList = false;

        if ( $forms = $this->call_api( 'forms', 'get' ) ) {
            foreach ( $forms as $form ) {
                $apiFormList[ $form['formid'] ] = $form['title'];
            }
        }

        return $apiFormList;

    }

}