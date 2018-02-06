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
class Enormail_Widget extends WP_Widget {

    protected $widget_slug = 'enormail-widget';

    public function __construct()
    {
        // Hooks fired when the Widget is activated and deactivated
        register_activation_hook( __FILE__, array( $this, 'activate' ) );
        register_deactivation_hook( __FILE__, array( $this, 'deactivate' ) );

        parent::__construct(
            $this->get_widget_slug(),
            __( 'Enormail Formulier', 'enormail' ),
            array(
                'classname'  => $this->get_widget_slug().'-class',
                'description' => __( 'Displays an Enormail subscribe form.', 'enormail' )
            )
        );

        // Refreshing the widget's cached output with each new post
        add_action( 'save_post',    array( $this, 'flush_widget_cache' ) );
        add_action( 'deleted_post', array( $this, 'flush_widget_cache' ) );
        add_action( 'switch_theme', array( $this, 'flush_widget_cache' ) );
    }

    public static function register() {

        register_widget( 'Enormail_Widget' );

    }

    public function get_widget_slug() {

        return $this->widget_slug;

    }

    public function widget( $args, $instance ) {

        global $wpdb;

        if (isset($instance['enormail_form_id'])) {
            $form_id = $instance['enormail_form_id'];

            if ($form_id > 0) {
                $form = $wpdb->get_row('SELECT * FROM ' . $wpdb->prefix . 'enormail_forms WHERE id = ' . $form_id, OBJECT);
            }

            if ($form) {
                echo '<div data-enormail-webform="'.$form->formid.'"></div>';
            }
        }

    }

    public function form( $instance ) {

        global $wpdb;

        if (isset($instance['enormail_form_id'])) {
            $id = $instance['enormail_form_id'];
        } else {
            $id = 0;
        }

        $formsList = null;
        $forms = $wpdb->get_results("SELECT id, name FROM {$wpdb->prefix}enormail_forms", OBJECT);

        if ($forms) {
            foreach ($forms as $form) {
                $formsList[$form->id] = $form->name;
            }

            include ENORMAIL_PLUGIN_PATH . 'admin/partials/enormail-admin-widget-form.php';
        } else {
            echo '<p>' . __( 'You do not have any forms to display. <a href="admin.php?page=enormail-admin">Please create a new form first</a>.', 'enormail' ) . '</p>';
        }

    }

    /**
     * Sanitize widget form values as they are saved.
     *
     * @see WP_Widget::update()
     *
     * @param array $new_instance Values just sent to be saved.
     * @param array $old_instance Previously saved values from database.
     *
     * @return array Updated safe values to be saved.
     */
    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['enormail_form_id'] = (
            ( ! empty( $new_instance['enormail_form_id'] ) ) ? absint( $new_instance['enormail_form_id'] ) : 0
        );

        return $instance;
    }

    public function activate() {

        // Nothing here...

    }

    public function deactivate() {

        // Nothing here...

    }

    public function flush_widget_cache()
    {
        // Nothing here yet...
    }

}
