<?php

namespace CD;

class Enqueue {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    public function admin_enqueue_scripts( $screen ) {
        // Add css and js to our settings page only.
        if( 'toplevel_page_custom_crud' == $screen ) {
            $main_asset = require CD_ROOT_PATH . 'assets/build/main.asset.php';

            wp_enqueue_style( 'react-settings', CD_ROOT_URL . 'assets/build/main.css', array(), $main_asset['version'] );
            wp_enqueue_script( 'react-settings', CD_ROOT_URL . 'assets/build/main.js', $main_asset['dependencies'], $main_asset['version'], array( 'in_footer' => true ) );

            wp_localize_script( 'react-settings', 'ReactSettings', array(
                'ajax_url' => admin_url( 'admin-ajax.php' ),
                'nonce'    => wp_create_nonce( 'react-settings' ),
            ) );
        }
    }

}
