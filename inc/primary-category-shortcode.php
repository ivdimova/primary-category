<?php
/**
 * Shortcode.
 */

namespace PrimaryCategory\ShortCode;

use PrimaryCategory\Database;

/**
 * Start it all.
 *
 * @return void.
 */
function bootstrap() : void {
	add_action( 'init', __NAMESPACE__ . '\\pc_shortcode_init' );
}

/**
 * Call the shortcode.
 *
 * @return void.
 */
function pc_shortcode_init() : void {
	add_shortcode( 'primary-category', __NAMESPACE__ . '\\primary_category_shortcode' );
}

/**
 * Shortcode output.
 *
 * @return string $output The shortcode content.
 */
function primary_category_shortcode() {
	$term_id = intval( Database\primary_category_get( get_the_ID() ) );
	
	if ( empty( $term_id ) || ! is_int( $term_id ) ) {
		return;
	}
	$pc_term = get_term_by( 'term_id', $term_id, 'category' );

	$output = '<span>' . esc_html__( 'Primary Category - ', 'primary-category' ) . $pc_term->name . '</span>';
	return $output;
}
