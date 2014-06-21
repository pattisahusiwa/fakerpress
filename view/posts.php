<?php
namespace FakerPress;

$taxonomies = get_taxonomies( array( 'public' => true ), 'object' );

$_json_taxonomies_output = array();
foreach ( $taxonomies as $key => $taxonomy ) {
	$_json_taxonomies_output[] = array(
		'id' => $taxonomy->name,
		'text' => $taxonomy->labels->name,
	);
}


$post_types = get_post_types( array( 'public' => true ), 'object' );

// Exclude Attachments as we don't support images yet
if ( isset( $post_types['attachment'] ) ){
	unset( $post_types['attachment'] );
}


$_json_post_types_output = array();
foreach ( $post_types as $key => $post_type ) {
	$_json_post_types_output[] = array(
		'id' => $post_type->name,
		'text' => $post_type->labels->name,
	);
}
?>
<div class='wrap'>
	<h2><?php echo esc_attr( Admin::$view->title ); ?></h2>

	<form method='post'>
		<?php wp_nonce_field( Plugin::$slug . '.request.' . Admin::$view->slug . ( isset( Admin::$view->action ) ? '.' . Admin::$view->action : '' ) ); ?>
		<table class="form-table" style="display: table;">
			<tbody>
				<tr>
					<th scope="row"><label for="fakerpress_qty"><?php _e( 'Quantity', 'fakerpress' ); ?></label></th>
					<td>
						<div id="fakerpress[qty]">
							<input style='width: 90px;' type='number' max='25' min='1' placeholder='<?php esc_attr_e( 'e.g.: 12', 'fakerpress' ); ?>' value='' name='fakerpress_qty' />
						</div>
						<p class="description"><?php _e( 'The amount of Posts you want to generate', 'fakerpress' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fakerpress_post_types"><?php _e( 'Post Type', 'fakerpress' ); ?></label></th>
					<td>
						<div id="fakerpress[post_types]">
							<input type='hidden' class='field-select2-simple' name='fakerpress_post_types' data-possibilities='<?php echo json_encode( $_json_post_types_output ); ?>' />
						</div>
						<p class="description"><?php _e( 'Sampling group of Post Types', 'fakerpress' ); ?></p>
					</td>
				</tr>
				<tr>
					<th scope="row"><label for="fakerpress_taxonomies"><?php _e( 'Taxonomies', 'fakerpress' ); ?></label></th>
					<td>
						<div id="fakerpress[taxonomies]">
							<input type='hidden' class='field-select2-simple' name='fakerpress_taxonomies' data-possibilities='<?php echo json_encode( $_json_taxonomies_output ); ?>' />
						</div>
						<p class="description"><?php _e( 'From which taxonomies the related terms should be selected', 'fakerpress' ); ?></p>
					</td>
				</tr>
			</tbody>
		</table>
		<?php submit_button( __( 'Generate', 'fakerpress' ), 'primary' ); ?>
	</form>
</div>