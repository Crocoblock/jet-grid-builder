<?php
namespace Posts_Grid_Builder\Endpoints;

use Posts_Grid_Builder\Plugin;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Terms class
 */
class Terms extends Base {

	private $thumbnail_size, $date_format, $category, $tags;

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'taxonomy-terms';
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {

		return array(
			'taxonomy'       => array(
				'default'    => 'category',
				'required'   => false,
			),
			'include'        => array(
				'default'    => '',
				'required'   => false,
			),
			'number'         => array(
				'default'    => '',
				'required'   => false,
			),
			'paged'          => array(
				'default'    => 1,
				'required'   => false,
			),
			'orderby'        => array(
				'default'    => 'id',
				'required'   => false,
			),
			'order'          => array(
				'default'    => 'DESC',
				'required'   => false,
			),
			'search'         => array(
				'default'    => '',
				'required'   => false,
			),
			'date_format'    => array(
				'default'    => 'F j, Y',
				'required'   => false,
			),
			'thumbnail_size' => array(
				'default'    => false,
				'required'   => false,
			),
			'items_type' => array(
				'default'  => 'default',
				'required' => false,
			),
			'jetengine_listing_id' => array(
				'default'  => false,
				'required' => false,
			),
		);
	}

	public function callback( $request ) {

		$args = $request->get_params();

		$query_args = array(
			'taxonomy'   => 'any' !== $args['taxonomy'] ? $args['taxonomy'] : get_taxonomies( array( 'public' => true ), 'names' ),
			'include'    => $args['include'],
			'number'     => $args['number'],
			'offset'     => $args['number'] ? $args['number'] * ($args['paged'] - 1) : '',
			'orderby'    => 'date' === $args['orderby'] ? 'id' : $args['orderby'],
			'order'      => $args['order'],
			'search'     => $args['search'],
			'hide_empty' => false
		);

		$this->thumbnail_size = $args['thumbnail_size'];
		$this->date_format = $args['date_format'];

		if ( $args['items_type'] === 'jetengine_listing' ) {
			jet_engine()->frontend->set_listing( $args['jetengine_listing_id'] );
		}

		$terms = get_terms( $query_args );

		foreach ( $terms as &$term ) {
			if ( $args['items_type'] === 'jetengine_listing' ) {
				$prepared_term = $this->prepare_jetengine_listing_term( $term );
			} else {
				$prepared_term = $this->prepare_term( $term );
			}

			$term = apply_filters( 'posts-grid-builder/taxonomy-term-data', $prepared_term );
		}

		$outputData = [];
		$outputData['terms'] = array_values( $terms );
		if ( 'any' !== $args['taxonomy'] ) {
			$outputData['page'] = ( int )$args['paged'];
			$outputData['pages'] = ceil( wp_count_terms( $args['taxonomy'], 'hide_empty=0' ) / $args['number'] );
		}

		return rest_ensure_response( $outputData );

	}

	public function prepare_term( $term ) {

		$thumb_id = get_term_meta( $term->term_id, 'jgb_term_thumbnail_id', true );

		$prepared_term = array(
			'id'               => $term->term_id,
			'permalink'        => get_term_link( $term->term_id ),
			'thumbnail_data'   => Plugin::instance()->get_thumbnail_data( $thumb_id, $this->thumbnail_size ),
			'term_title'       => htmlspecialchars_decode( $term->name ),
			'term_slug'        => $term->slug,
			'term_count'       => $term->count,
			'term_description' => $term->description,
			'term_taxonomy'    => get_taxonomy( $term->taxonomy )->labels->singular_name
		);

		return $prepared_term;
	}

	public function prepare_jetengine_listing_term( $term ) {

		ob_start();
		echo jet_engine()->frontend->get_listing_item( $term );
		$content = ob_get_clean();

		$prepared_term = array(
			'id'      => $term->term_id,
			'content' => $content
		);

		return $prepared_term;

	}

}