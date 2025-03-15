<?php
/**
 * Plugin Name: Class 29 WordPress Widget
 */

class Class_28_WordPress_Widget {

    public function __construct() {
        require_once __DIR__ . '/widgets/Custom_Widget.php';

        new Custom_Widget();
    }

}

new Class_28_WordPress_Widget();
