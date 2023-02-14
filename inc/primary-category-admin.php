<?php
/**
 * Admin settings.
 */

namespace PrimaryCategory\Admin;

use PrimaryCategory\Database;

/**
 * Start the admin settings.
 *
 * @return void.
 */
function bootstrap() : void {
	add_action( 'enqueue_block_editor_assets', __NAMESPACE__ . '\\enqueue_block_editor_assets' );
	add_action( 'add_meta_boxes', __NAMESPACE__ . '\\pc_register_meta_box' );
	add_action( 'save_post', __NAMESPACE__ . '\\pc_metabox_save' );
}

/**
 * Enqueue the editor script.
 *
 * @return void.
 */
function enqueue_block_editor_assets() : void {
	wp_enqueue_script(
		'primary-category',
		plugins_url( '/build/index.js', __FILE__ ),
		[ 'wp-components' ],
		'0.0.4',
		true
	);
}

/**
 * Adds meta box for primary category.
 *
 * @return void.
 */
function pc_register_meta_box() : void {
	add_meta_box(
		'pc-meta-box-id',
		esc_html__( 'Primary Category', 'primary-category' ),
		__NAMESPACE__ . '\\pc_meta_box_callback',
		'post',
		'side',
		'high'
	);
}

/**
 * Metabox content.
 *
 * @param object $post The post object.
 * @return void.
 */
function pc_meta_box_callback( $post ) : void {
	wp_nonce_field( 'pc_metabox_nonce', 'pc_nonce' );
	$custom  = get_post_custom( $post->ID );
	$selected = isset( $custom['primary_category'] ) ? esc_attr( $custom['primary_category'][0] ) : '';

	$categories = get_categories(); ?>
	<label for="mb_id"><?php echo esc_html( 'Select Primary Category', 'primary_category' ); ?></label>
	<select class="pc-select" name="pc-select" id="pc-select">
	<?php
	foreach ( $categories as $term ) {
		$term_name = $term->name;
		$term_id = $term->term_id;
		?>
		<option value="<?php echo esc_attr( $term_id ); ?>" <?php echo selected( $selected, $term_id ); ?>>
			<?php echo esc_html( $term_name ); ?>
		</option>
		<?php } ?>

	</select>
	<?php
}

/**
 * Save metabox.
 *
 * @param int $post_id The post ID.
 * @return void.
 */
function pc_metabox_save( $post_id ) : void {
	if ( ! isset( $_POST['pc-select'] ) ) {
		return;
	}
	if ( ! isset( $_POST['pc_nonce'] ) || ! wp_verify_nonce( $_POST['pc_nonce'], 'pc_metabox_nonce' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;

	}
	$primary_category = intval( wp_unslash( $_POST['pc-select'] ) );
	if ( isset( $_POST['pc-select'] ) ) {
		update_post_meta( $post_id, 'primary_category', $primary_category );
		Database\primary_category_save( $post_id, $primary_category );
		update_taxonomies( $post_id, $primary_category );
	}
}

/**
 * Update taxnomies.
 *
 * @param int $post_id The post ID.
 * @param int $primary_category The post $primary category ID.
 * @return void.
 */
function update_taxonomies( $post_id, $primary_category ) : void {
	$taxonomies = wp_get_object_terms( $post_id, 'category' );
	$term = get_term( $primary_category );
	if ( ! in_array( $term, $taxonomies ) ) {
		wp_set_post_terms( $post_id, $term->term_id, $term->taxonomy, true );
	}
}
