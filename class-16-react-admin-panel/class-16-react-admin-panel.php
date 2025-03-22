<?php
/**
 * Plugin Name: React Admin Panel
 * Plugin URI: https://example.com
 * Description: This is plugin description.
 * Version: 1.0.0
 * Author: weDevs Academy
 * Author URI: https://wedevsacademy.com
 * License: GPLv2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wedevs-academy-batch-3
 */

if ( ! defined( 'ABSPATH' ) ) {
    return;
}

class ReactAdminPanel {
    public function __construct() {
        $this->define_constants();
        $this->load_classes();
    }

    private function load_classes() {
        require_once RAP_ROOT_PATH . 'includes/Admin_Menu.php';
        require_once RAP_ROOT_PATH . 'includes/Enqueue.php';
        require_once RAP_ROOT_PATH . 'includes/Ajax.php';
        require_once RAP_ROOT_PATH . 'includes/license/Settings.php';

        new RAP\Admin_Menu();
        new RAP\Enqueue();
        new RAP\Ajax();

        new RAP\License\Settings();
    }

    private function define_constants() {
        define( 'RAP_ROOT_PATH', plugin_dir_path( __FILE__ ) );
        define( 'RAP_ROOT_URL', plugin_dir_url( __FILE__ ) );
    }
}

new ReactAdminPanel();
