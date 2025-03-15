<?php
/**
 * Plugin Name: class 30 woocommerce
 */

class Class_30 {

    public function __construct() {

        add_action( 'init', array( $this, 'init' ));

        add_action( 'woocommerce_account_dashboard', array( $this, 'woocommerce_account_content' ), 11 );
        add_action( 'woocommerce_account_navigation', array( $this, 'woocommerce_account_navigation' ), 11 );

        add_filter( 'woocommerce_thankyou_order_received_text', function() {
            return 'This is a custom text';
        } );
    }

    public function init() {
        remove_action( 'woocommerce_account_navigation', 'woocommerce_account_navigation' );
    }

    public function woocommerce_account_content() {
        woocommerce_account_orders( 1 );
    }

    public function woocommerce_account_navigation() {
        echo '<div class="custom-nav">';

        woocommerce_account_navigation();

        echo '</div>';
    }
}

new Class_30();
