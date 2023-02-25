<?php
/**
 * Plugin Name: Primary Category.
 * Plugin URI: http:/it.ivdimova.com/
 * Author: ivdimova
 * Description: Adds option to select primary category.
 * Author URI: http://it.ivdimova.com/
 * Version: 1.0
 * License: GPL2
 */

namespace PrimaryCategory;

require_once __DIR__ . '/inc/namespace.php';
require_once __DIR__ . '/inc/primary-category-db.php';
register_activation_hook( __FILE__, __NAMESPACE__ . '\Database\\primary_category_db' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\Database\\remove_primary_category_db' );

function primary_category_block_init() {
	register_block_type( __DIR__ . '/build' );
}
add_action( 'init', __NAMESPACE__ . '\\primary_category_block_init' );
