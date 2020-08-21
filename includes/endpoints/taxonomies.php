<?php
namespace Posts_Grid_Builder\Endpoints;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Taxonomies class
 */
class Taxonomies extends Base {
	
	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'taxonomies';
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
	 * Excluded taxonomies list
	 *
	 * @return [type] [description]
	 */
	public function excluded_taxonomies() {
		return apply_filters( 'posts-grid-builder/api/taxonomies/exclude', array(
			'post_format',
			'product_shipping_class'
		) );
	}

	/**
	 * Endpoint callback
	 */
	public function callback( $request ) {

		$taxonomies = get_taxonomies( array(
			'public' => true,
		) );

		$excluded_taxonomies = $this->excluded_taxonomies();

		$taxonomies = array_map( function( $slug ) use ( $excluded_taxonomies ) {

			if ( in_array( $slug, $excluded_taxonomies ) ) {
				return false;
			}

			$taxonomy = get_taxonomy( $slug );

			return array(
				'slug'  => $slug,
				'label' => $taxonomy->label,
			);

		}, $taxonomies );

		$taxonomies = array_filter( $taxonomies );

		return rest_ensure_response( array(
			'taxonomies' => $taxonomies,
		) );

	}

}
