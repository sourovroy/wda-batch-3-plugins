<?php
/**
 * Plugin Name: Class 19 custom database
 */

class Class_19_Custom_Database {

    public $version = '1.2.6';

    private $table_name;

    public function __construct() {
        global $wpdb;

        $this->table_name = $wpdb->prefix . 'custom_posts';

        register_activation_hook( __FILE__, array( $this, 'register_activation_hook' ) );

        add_action( 'admin_init', array( $this, 'admin_init' ) );

        $this->define_constants();

        require CD_ROOT_PATH . '/vendor/autoload.php';

        $this->load_classes();
    }

    public function register_activation_hook() {
        $this->create_or_update_table();
    }

    public function admin_init() {
        // If the user is not administrator.
        if ( ! current_user_can( 'update_plugins' ) ) {
            return;
        }

        $current_version = get_option( 'class_19_custom_database_version', null );

        if ( version_compare( $current_version, $this->version, '<' ) ) {
            // Update the database.
            $this->create_or_update_table();
        }

    }

    private function create_or_update_table() {
        require_once ABSPATH . 'wp-admin/includes/upgrade.php';
        global $wpdb;
        $table_name = $this->table_name;
        $wpdb_collate = $wpdb->collate;

        $sql = "
            CREATE TABLE {$table_name} (
                id INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
                title VARCHAR(255),
                description TEXT,
                image_url TEXT,
                created_at TIMESTAMP NOT NULL DEFAULT (CURRENT_TIMESTAMP),
                PRIMARY KEY (id)
            )
            COLLATE {$wpdb_collate};
        ";

        dbDelta( $sql );

        update_option( 'class_19_custom_database_version', $this->version );
    }

    private function load_classes() {
        new CD\Admin_Menu();
        new CD\Enqueue();
        new CD\Ajax();
    }

    private function define_constants() {
        define( 'CD_ROOT_PATH', plugin_dir_path( __FILE__ ) );
        define( 'CD_ROOT_URL', plugin_dir_url( __FILE__ ) );
        define( 'CD_CUSTOM_TABLE_NAME', $GLOBALS['wpdb']->prefix . 'custom_posts' );
    }
}

new Class_19_Custom_Database();
