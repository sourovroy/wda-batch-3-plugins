<?php
/**
 * Plugin Name: Class 27 WP Cron
 */

class Class_27_WP_CRON {

    public function __construct() {
        add_shortcode( 'custom_form', array( $this, 'custom_form' ) );

        add_action( 'send_email_schedule', array( $this, 'send_email_schedule' ) );
        add_action( 'cron_send_user_email', array( $this, 'cron_send_user_email' ) );

        register_activation_hook( __FILE__, array( $this, 'register_activation_hook' ) );
        register_deactivation_hook( __FILE__, array( $this, 'register_deactivation_hook' ) );

        add_action('phpmailer_init', array( $this, 'mailtrap'));

        add_filter( 'cron_schedules', array( $this, 'cron_add_new_schedules' ) );
    }

    public function custom_form() {
        if ( isset( $_POST['send_email'] ) ) {
            wp_schedule_single_event( time() + (60 * 2), 'send_email_schedule' );
        }
        ob_start();
        ?>
            <form action="" method="post">
                <button type="submit" name="send_email">Send Email</button>
            </form>
        <?php
        return ob_get_clean();
    }

    public function send_email_schedule() {
        error_log('send_email_schedule');
    }

    public function register_activation_hook() {
        // Register cron.
        if ( ! wp_next_scheduled( 'cron_send_user_email' ) ) {
            wp_schedule_event( time() + (60 * 60), 'every_two_hours', 'cron_send_user_email' );
        }
    }

    public function cron_send_user_email() {
        $message = 'You site total user is: ' . count_users()['total_users'];

        wp_mail(get_option('admin_email'), 'You Site Total Users', $message);
    }

    /**
     * Setup mailtrap
     */
    public function mailtrap($phpmailer) {
        $phpmailer->isSMTP();
        $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 2525;
        $phpmailer->Username = MAILTRAP_USERNAME;
        $phpmailer->Password = MAILTRAP_PASSWORD;
    }

    public function register_deactivation_hook() {
        wp_clear_scheduled_hook( 'cron_send_user_email' );
    }

    public function cron_add_new_schedules( $schedules ) {
        $schedules['every_two_hours'] = array(
            'interval' => (60 * 60 * 2),
            'display' => 'Every two hours',
        );

        return $schedules;
    }
}

new Class_27_WP_CRON();
