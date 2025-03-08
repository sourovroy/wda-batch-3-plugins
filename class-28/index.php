<?php
/**
 * Plugin Name: Class 28 Dashboard Widget
 */

class Class_28_Dashboard_Widget {

    public function __construct() {

        add_action( 'wp_dashboard_setup', array( $this, 'wp_dashboard_setup' ) );
        add_action( 'wp_ajax_wda_save_dashboard', array( $this, 'ajax_wda_save_dashboard' ) );

    }

    public function wp_dashboard_setup() {
        global $wp_meta_boxes;

        $id = 'wda-custom-dashboard-widget';

        wp_add_dashboard_widget(
            $id,
            'Custom dashboard widget',
            array( $this, 'custom_dashboard_widget' )
        );

        $default_dashboard = $wp_meta_boxes['dashboard']['normal']['core'];

        // Backup our widget.
        $backup = array( $id => $default_dashboard[ $id ] );

        unset( $default_dashboard[ $id ] );

        $sorted_dashboard = array_merge( $backup, $default_dashboard );

        // Re-setup it.
        $wp_meta_boxes['dashboard']['normal']['core'] = $sorted_dashboard;
    }

    public function custom_dashboard_widget() {
        ?>
            <form action="<?php echo admin_url('/admin-ajax.php'); ?>" method="POST">
                <input type="hidden" name="action" value="wda_save_dashboard">
                <input type="text" name="wda_post_title">
                <button type="submit" class="button">Save</button>
            </form>
        <?php
    }

    public function ajax_wda_save_dashboard() {
        wp_insert_post(array(
            'post_title' => $_POST['wda_post_title']
        ));

        wp_safe_redirect( admin_url('/edit.php') );
        exit;
    }
}

new Class_28_Dashboard_Widget();
