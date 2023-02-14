<?php
/**
 * Primary Category Database table.
 */

namespace PrimaryCategory\Database;

const TABLE_NAME = 'primary_category';
const PC_DB_VERSION = '1.0';

/**
 * Create the Databse.
 *
 * @return void.
 */
function primary_category_db() : void {
	global $wpdb;

	$table_name = $wpdb->prefix . TABLE_NAME;

	$charset_collate = $wpdb->get_charset_collate();

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
		id mediumint(9) NOT NULL AUTO_INCREMENT,
		post_id mediumint(9) NOT NULL,
		term_id mediumint(9) NOT NULL,
		time_created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
		PRIMARY KEY  (id)
	) $charset_collate;";

	require_once ABSPATH . 'wp-admin/includes/upgrade.php';
	dbDelta( $sql );

	add_option( 'pc_db_version', PC_DB_VERSION );

}

/**
 * Save the data.
 *
 * @param int $post_id The post id.
 * @param int $term_id The term id.
 *
 * @return void.
 */
function primary_category_save( $post_id, $term_id ) : void {
	global $wpdb;
	$table_name = $wpdb->prefix . TABLE_NAME;
	$wpdb->replace(
		$table_name,
		[
			'post_id' => $post_id,
			'term_id' => $term_id,
			'time_created' => current_time( 'mysql' ),
		]
	);
}

/**
 * Get the data per post
 *
 * @param int $post_id The post id.
 *
 * @return int $term_id The term id for the primary term.
 */
function primary_category_get( $post_id ) {
	global $wpdb;

	$term_id = $wpdb->get_var( $wpdb->prepare(
		'SELECT `term_id` FROM wp_primary_category WHERE `post_id` = %d',
		$post_id
	) );

	return $term_id;
}

/**
 * Remove the Databse on deactivation.
 *
 * @return void.
 */
function remove_primary_category_db() : void {
	global $wpdb;

	$table_name = $wpdb->prefix . TABLE_NAME;
	$sql = "DROP TABLE IF EXISTS $table_name";
	$wpdb->query( $sql );
	delete_option( 'pc_db_version' );
}
