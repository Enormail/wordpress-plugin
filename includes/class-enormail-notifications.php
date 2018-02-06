<?php

class Enormail_Notifications {

    public static function display($message) {

        $message = str_replace( '-', '_', sanitize_key( $message ) );

        return self::get_message( $message );
    }

    private static function get_message($message) {

        $messages = array(
            'apikey_updated' => array(
                'message' => __( 'Your API key is updated and your Enormail account has been connected.', 'enormail' ),
                'type' => 'success',
                'dismissible' => true
            ),
            'apikey_failed' => array(
                'message' => __( 'Your API key is invalid or disabled, please update your settings.', 'enormail' ),
                'type' => 'error',
                'dismissible' => false
            ),
            'form_created' => array(
                'message' => __( 'Your form has been created.', 'enormail' ),
                'type' => 'success',
                'dismissible' => true
            ),
            'form_saved' => array(
                'message' => __( 'Your form has been saved.', 'enormail' ),
                'type' => 'success',
                'dismissible' => true
            ),
            'form_duplicate' => array(
                'message' => __( 'You have already embedded this form in your website.', 'enormail' ),
                'type' => 'error',
                'dismissible' => true
            ),
            'form_not_found' => array(
                'message' => __( 'We could not find this form.', 'enormail' ),
                'type' => 'error',
                'dismissible' => true
            ),
            'form_deactivated' => array(
                'message' => __( 'Your form has been deactivated.', 'enormail' ),
                'type' => 'success',
                'dismissible' => true
            ),
            'form_activated' => array(
                'message' => __( 'Your form has been activated.', 'enormail' ),
                'type' => 'success',
                'dismissible' => true
            ),
            'form_deleted' => array(
                'message' => __( 'Your form has been deleted.', 'enormail' ),
                'type' => 'success',
                'dismissible' => true
            )
        );

        if ( isset( $messages[$message] ) ) {

            return self::render(
                $messages[$message]['message'],
                $messages[$message]['type'],
                $messages[$message]['dismissible']
            );

        }

        return '';
    }

    private static function render($message, $type = 'success', $dismissible = true) {

        $dismissible = ($dismissible == true) ? ' is-dismissible' : '';

        return  '<div class="enormail-notice notice notice-' . $type . $dismissible .'"><p>' . esc_html($message) . '</p></div>';

    }

}