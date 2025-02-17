<?php
/**
 * Plugin Name: Class 23-24 Notice and Rules
 */

class Class_23_24_Notice_And_Rules {

    public $version = '1.0.0';

    public function __construct() {
        // add_action( 'admin_notices', array( $this, 'admin_notices' ) );
        add_action( 'admin_notices', array( $this, 'default_admin_notice' ) );

        add_action('wp_ajax_user_notice_click_here', array( $this, 'user_notice_click_here' ));
        add_action('wp_ajax_default_notice_close', array( $this, 'default_notice_close' ));

        add_action('init', array( $this, 'init' ));

        add_filter( 'template_include', array( $this, 'template_include' ) );
    }

    public function admin_notices() {
        $clicked = get_option( 'user_notice_clicked_here', false );

        if ( $clicked ) {
            return;
        }
        ?>
        <div class="notice academy-notice">
        <style>
            .notice.academy-notice {
                background: transparent;
                border: 0px none;
                box-shadow: 0 0 0;
                margin: 0;
                padding: 0;
            }

            .notice.academy-notice p {
                margin: 0;
                padding: 0;
            }

            .notice.academy-notice .warning {
                background-color: #EFEFEF;
                border: 3px solid #444;
                padding: 1rem;
                margin: 2rem 0;
            }

            .warning::before {
                content: "WARNING";
                background: #FFEEAA;
                width: 7.5rem;
                border-right: 3px solid #444;
                border-bottom: 3px solid #444;
                display: block;
                text-align: center;
                position: relative;
                left: -1rem;
                top: -1rem;
                padding: 2px 10px;
                font-weight: bold;
            }
        </style>

        <p class="warning">
            Here be dragons! This is my <b>WARNING</b> box!
            <a href="<?php echo admin_url('/'); ?>admin-ajax.php?action=user_notice_click_here" class="button action">Click Here</a>
        </p>
        </div>
        <?php
    }

    public function user_notice_click_here() {
        // Complex functionality.

        update_option( 'user_notice_clicked_here', 'true' );

        wp_safe_redirect( admin_url('/index.php') );
        exit;
    }

    public function default_admin_notice() {
        $closed = get_option('user_default_notice_close', false);
        if ( $closed ) {
            return;
        }
        ?>
        <div class="notice notice-success is-dismissible academy-awesome-notice">
            <p>This is an awesome notice.</p>
        </div>
        <script>
            jQuery('body').on( "click", '.academy-awesome-notice .notice-dismiss', function() {
                jQuery.ajax({
                    url: ajaxurl,
                    method: 'POST',
                    data: {
                        action: 'default_notice_close'
                    }
                });
            });
        </script>
        <?php
    }

    public function default_notice_close() {

        update_option( 'user_default_notice_close', 'true' );

        exit;
    }

    public function init() {
        add_rewrite_rule(
            'sourov',
            'index.php?page_id=97',
            'top'
        );

        add_rewrite_rule(
            'custom/([a-z0-9-]+)[/]?$',
            'index.php?my_custom_name=$matches[1]',
            'top'
        );

        add_rewrite_tag('%my_custom_name%', '([^&]+)');
    }

    public function template_include( $path ) {

        if ( get_query_var('my_custom_name') == 'something' ) {
            return __DIR__ . '/page-template.php';
        }

        return $path;
    }
}

new Class_23_24_Notice_And_Rules();
