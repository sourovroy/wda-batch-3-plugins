<?php
/**
 * Plugin Name: Class 26 REST API
 */

class Class_26_REST_API {

    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'rest_api_init' ) );
        add_shortcode( 'api_access', array( $this, 'api_access' ) );
    }

    public function rest_api_init() {
        register_rest_route( 'wda/v1', '/invoices', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_invoices_callback' ),
            'args' => array(
                'per_page' => array(
                    'validate_callback' => function( $param ) {
                        return is_numeric( $param );
                    },
                    'sanitize_callback' => function( $param ) {
                        return intval( $param );
                    },
                    'default' => 2
                ),
            ),
            'permission_callback' => '__return_true'
        ) );

        register_rest_route( 'wda/v1', '/invoices/(?P<id>\d+)', array(
            'methods' => 'GET',
            'callback' => array( $this, 'get_invoice_callback' ),
            'args' => array(
                'id' => array(
                    'validate_callback' => function( $param ) {
                        return is_numeric( $param );
                    },
                    'sanitize_callback' => function( $param ) {
                        return intval( $param );
                    },
                    'required' => true,
                ),
            ),
            'permission_callback' => '__return_true',
        ) );

        register_rest_route( 'wda/v1', '/invoices', $this->register_create_invoice() );
    }

    public function get_invoices_callback( WP_REST_Request $request ) {
        $per_page = $request->get_param('per_page');

        $posts = get_posts( array(
            'post_type' => 'post',
            'posts_per_page' => $per_page,
        ) );

        return new WP_REST_Response( $posts, 200 );
    }

    public function get_invoice_callback( WP_REST_Request $request ) {
        $post_id = $request->get_param('id');

        $post = get_post( $post_id );

        $response = new WP_REST_Response( $post, 200 );

        $response->header( 'X-WP-Invoice', $post_id );

        return $response;
    }

    private function register_create_invoice() {
        return array(
            'methods' => 'POST',
            'callback' => array( $this, 'create_invoice_callback' ),
            'args' => array(
                'title' => array(
                    'sanitize_callback' => function( $param ) {
                        return sanitize_text_field( $param );
                    },
                    'required' => true,
                    'validate_callback' => function( $param ) {
                        return ! empty( $param );
                    },
                ),
            ),
            'permission_callback' => function() {
                return current_user_can( 'publish_posts' );
            }
        );
    }

    public function create_invoice_callback( WP_REST_Request $request ) {
        $post_title = $request->get_param('title');

        wp_insert_post( array(
            'post_type' => 'post',
            'post_title' => $post_title,
            'post_status' => 'publish'
        ) );

        return new WP_REST_Response( array(
            'success' => true
        ) );
    }

    public function api_access() {
        ob_start();
        ?>
        <script>
            (function(){
                fetch("http://wda-wp-batch-3.site/wp-json/wda/v1/invoices")
                    .then(response => response.json()).then((response) => {
                        console.log(response);
                    });
            })();
        </script>
        <?php
        return ob_get_clean();
    }
}

new Class_26_REST_API();
