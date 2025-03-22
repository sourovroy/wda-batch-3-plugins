<?php

namespace RAP;

class Ajax {
    public function __construct() {
        add_action( 'wp_ajax_react_form_submit', array( $this, 'react_form_submit' ) );
        add_action( 'wp_ajax_react_get_form_data', array( $this, 'react_get_form_data' ) );
    }

    public function react_form_submit() {
        check_ajax_referer( 'react-settings', 'nonce' );

        $title = isset( $_POST['title'] ) ? sanitize_text_field( wp_unslash( $_POST['title'] ) ) : '';
        $choose_option = isset( $_POST['choose_option'] ) ? sanitize_text_field( wp_unslash( $_POST['choose_option'] ) ) : '';
        $select_radio = isset( $_POST['select_radio'] ) ? sanitize_text_field( wp_unslash( $_POST['select_radio'] ) ) : '';

        $select_checkbox = array();

        if ( isset( $_POST['select_checkbox'] ) && is_array( $_POST['select_checkbox'] ) ) {
            $select_checkbox = array_map( 'sanitize_text_field', wp_unslash( $_POST['select_checkbox'] ) );
        }

        $data = array(
            'title' => $title,
            'choose_option' => $choose_option,
            'select_radio' => $select_radio,
            'select_checkbox' => $select_checkbox,
        );

        update_option( 'react_settings', $data );

        wp_send_json_success();
    }

    public function react_get_form_data() {
        check_ajax_referer( 'react-settings', 'nonce' );

        $data = get_option( 'react_settings', array() );

        if ( ! isset( $data['select_checkbox'] ) ) {
            $data['select_checkbox'] = array();
        }

        wp_send_json_success( $data );
    }
}
