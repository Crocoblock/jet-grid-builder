<?php
namespace Posts_Grid_Builder\Endpoints;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Post_Types class
 */
class Post_Types extends Base {

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'post-types';
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {
		return array();
	}

	/**
	 * Excluded post types list
	 *
	 * @return [type] [description]
	 */
	public function excluded_post_types() {
		return apply_filters( 'posts-grid-builder/api/post-types/exclude', array(
			'attachment',
			'elementor_library',
			'jet-smart-filters',
			'jet-engine',
			'jet-theme-core',
			'jet-engine-booking',
			'jet-woo-builder',
			'jet-popup',
			'jet-menu'
		) );
	}

	public function callback( $request ) {

		$post_types = get_post_types( array(
			'public' => true,
		) );

		$excluded_post_types = $this->excluded_post_types();

		$post_types = array_map( function( $slug ) use ( $excluded_post_types ) {

			if ( in_array( $slug, $excluded_post_types ) ) {
				return false;
			}

			$post_type = get_post_type_object( $slug );

			return array(
				'slug'      => $slug,
				'label'     => $post_type->label,
				'menu_icon' => $post_type->menu_icon,
			);

		}, $post_types );

		$post_types = array_filter( $post_types );

		return rest_ensure_response( array(
			'post_types' => $post_types,
		) );

	}

}
