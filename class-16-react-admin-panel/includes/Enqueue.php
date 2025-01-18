<?php

namespace RAP;

class Enqueue {
    public function __construct() {
        add_action( 'admin_enqueue_scripts', array( $this, 'admin_enqueue_scripts' ) );
    }

    public function admin_enqueue_scripts( $screen ) {
        // Add css and js to our settings page only.
        if( 'toplevel_page_react_admin_settings' == $screen ) {
            $main_asset = require RAP_ROOT_PATH . 'assets/build/main.asset.php';

            wp_enqueue_script( 'react-settings', RAP_ROOT_URL . 'assets/build/main.js', $main_asset['dependencies'], $main_asset['version'], array( 'in_footer' => true ) );
        }
    }

}
