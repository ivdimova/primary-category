<?php
/**
 * Plugin Name: Primary Category.
 * Plugin URI: http:/it.ivdimova.com/
 * Author: ivdimova
 * Description: Adds option to select primary category.
 * Author URI: http://it.ivdimova.com/
 * Version: 2.0
 * License: GPL2
 */

namespace PrimaryCategory;

require_once __DIR__ . '/inc/namespace.php';
require_once __DIR__ . '/inc/primary-category-db.php';
register_activation_hook( __FILE__, __NAMESPACE__ . '\Database\\primary_category_db' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\Database\\remove_primary_category_db' );
