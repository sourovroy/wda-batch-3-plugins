<?php
/**
 * Plugin Name:       Copyright Date Block
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       copyright-date-block
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function create_block_copyright_date_block_block_init() {
	register_block_type( __DIR__ . '/build/copyright-date-block' );
	register_block_type( __DIR__ . '/build/hero-section' );
	register_block_type( __DIR__ . '/build/popular-post' );
}
add_action( 'init', 'create_block_copyright_date_block_block_init' );

function save_popular_post_meta() {
	if ( is_singular('post') ) {
		$post_id = get_the_ID();

		$post_visit = get_post_meta( $post_id, 'block_post_visit', true );

		if ( is_numeric( $post_visit ) ) {
			$post_visit = (int) $post_visit;
		} else {
			$post_visit = 0;
		}

		$post_visit++;

		update_post_meta( $post_id, 'block_post_visit', $post_visit );
	}
}
add_action( 'wp_head', 'save_popular_post_meta' );

add_action( 'wp_ajax_get_popular_post_items', function() {
	$query = run_posts_query();

	wp_send_json( $query->posts );
} );

function run_posts_query() {
	return new WP_Query( array(
		'post_type' => 'post',
		'meta_key' => 'block_post_visit',
		'orderby' => array( 'meta_value_num' => 'DESC' ),
	) );
}
