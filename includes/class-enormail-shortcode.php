<?php

class Enormail_Shortcode {

    protected $shortcode_tag = 'enormail_form';

    public function register() {

        add_shortcode( $this->shortcode_tag, array( $this,  'shortcode'));

        add_action(
            'wp_ajax_nopriv_enormail_tinymce_window',
            array($this, 'tinymce_window')
        );

        add_action(
            'wp_ajax_enormail_tinymce_window',
            array($this, 'tinymce_window')
        );

        if ( is_admin() ) {
            if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
                return;
            }

            if ( get_user_option( 'rich_editing' ) == 'true' ) {
                add_filter( 'mce_external_plugins', array( $this, 'register_tinymce_plugin' ) );
                add_filter( 'mce_buttons', array($this, 'register_tinymce_button' ) );
                add_filter( 'mce_external_languages', array($this, 'register_tinymce_localisation') );
            }
        }

    }

    public function register_tinymce_plugin( $plugin_array = array() ) {

        $plugin_array[$this->shortcode_tag] = ENORMAIL_PLUGIN_URL . 'admin/js/enormail-tinymce-plugin.js?v=2';

        return $plugin_array;

    }

    public function register_tinymce_button( $buttons ) {

        array_push( $buttons, $this->shortcode_tag );

        return $buttons;

    }

    public function register_tinymce_localisation( $mce_external_languages ) {

        $mce_external_languages[ 'enormail' ] = ENORMAIL_PLUGIN_PATH . 'includes/tinymce/i18n.php';

        return $mce_external_languages;

    }

    public function tinymce_window() {

        global $wpdb;

        $formsList = null;
        $forms = $wpdb->get_results( "SELECT id, name FROM {$wpdb->prefix}enormail_forms", OBJECT );

        if ( $forms ) {
            foreach ( $forms as $form ) {
                $formsList[$form->id] = $form->name;
            }
        }

        require_once ENORMAIL_PLUGIN_PATH . 'admin/partials/enormail-admin-tinymce-window.php';

    }

    public function shortcode($atts) {

        $id = isset( $atts['form_id'] ) ? absint( $atts['form_id'] ) : 0;

        if ( $id > 0 ) {
            global $wpdb;

            $sql = $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}enormail_forms WHERE id = %d", $id );

            if ( $form = $wpdb->get_row( $sql ) ) {
                if ( $form->active == 1 ) {
                    return '<div class="" data-enormail-webform="'.$form->formid.'"></div>';
                }
            }
        }

        return '';

    }

}