<?php

namespace RAP;

class Admin_Menu {
    public function __construct() {
        add_action( 'admin_menu', array( $this, 'admin_menu' ) );
    }

    public function admin_menu() {
        add_menu_page(
            'React Settings',
            'React Settings',
            'administrator',
            'react_admin_settings',
            array( $this, 'react_admin_settings' )
        );
    }

    public function react_admin_settings() {
        echo '<div id="react-admin-settings-app"></div>';
    }
}
