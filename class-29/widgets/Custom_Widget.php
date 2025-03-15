<?php

class Custom_Widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'custom-widget-id',
            'Custom Widget',
        );

        add_action( 'widgets_init', function() {
            register_widget( self::class );
        });
    }

    public function widget( $args, $instance ) {
        echo $args['before_widget'];

        printf(
            '%s%s%s',
            $args['before_title'],
            $instance['wda_title'] ?? 'Custom Title',
            $args['after_title'],
        );

        $posts = get_posts(array(
            'post_type' => $instance['wda_post_type'] ?? 'post',
        ));

        echo '<ul>';

        foreach ( $posts as $post ) {
            printf( '<li>%s</li>', $post->post_title );
        }

        echo '</ul>';

        echo $args['after_widget'];
    }

    public function form( $instance ) {
        $post_types = get_post_types(array(
            'public' => true,
        ));

        $selected = $instance['wda_post_type'] ?? 'post';
        $title = $instance['wda_title'] ?? 'Custom Title';
        ?>
        <p>
            <label for="">Title</label>
            <input type="text"  name="<?php echo esc_attr( $this->get_field_name( 'wda_title' ) ); ?>" value="<?php echo esc_attr( $title ); ?>">
        </p>
        <p>
            <label for="">Choose Post Type</label>
            <select name="<?php echo esc_attr( $this->get_field_name( 'wda_post_type' ) ); ?>">
                <?php foreach ( $post_types as $post_type ): ?>
                <option value="<?php echo $post_type ?>" <?php selected( $selected, $post_type ); ?>><?php echo $post_type ?></option>
                <?php endforeach; ?>
            </select>
        </p>
        <?php
    }
}
