<?php
namespace Posts_Grid_Builder\Endpoints;

use Posts_Grid_Builder\Plugin;
use Elementor\Plugin as Elementor;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define Posts class
 */
class Posts extends Base {

	private $thumbnail_size, $date_format, $jet_woo_builder_archive_id;

	/**
	 * Returns route name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'posts';
	}

	/**
	 * Returns arguments config
	 *
	 * @return [type] [description]
	 */
	public function get_args() {

		return array(
			'post_type' => array(
				'default'  => 'post',
				'required' => false,
			),
			'posts_per_page' => array(
				'default'  => -1,
				'required' => false,
			),
			'orderby' => array(
				'default'  => 'date',
				'required' => false,
			),
			'order' => array(
				'default'  => 'DESC',
				'required' => false,
			),
			'paged' => array(
				'default'  => 1,
				'required' => false,
			),
			'post__in'       => array(
				'default'  => '',
				'required' => false,
			),
			'post__not_in' => array(
				'default'  => '',
				'required' => false,
			),
			'search' => array(
				'default'  => '',
				'required' => false,
			),
			'date_format' => array(
				'default'    => 'F j, Y',
				'required'   => false,
			),
			'thumbnail_size' => array(
				'default'  => false,
				'required' => false,
			),
			'items_type' => array(
				'default'  => 'default',
				'required' => false,
			),
			'woo_items_type' => array(
				'default'  => 'default',
				'required' => false,
			),
			'jetengine_listing_id' => array(
				'default'  => false,
				'required' => false,
			),
			'jet_woo_builder_archive_id' => array(
				'default'  => false,
				'required' => false,
			),
		);
	}

	public function callback( $request ) {

		$args = $request->get_params();

		$query_args = array(
			'post_type'           => $args['post_type'],
			'posts_per_page'      => $args['posts_per_page'],
			'orderby'             => $args['orderby'],
			'order'               => $args['order'],
			'paged'               => $args['paged'],
			'post__in'            => $args['post__in'],
			'post__not_in'        => $args['post__not_in'],
			'ignore_sticky_posts' => true
		);

		$this->thumbnail_size = $args['thumbnail_size'];
		$this->date_format = $args['date_format'];
		$this->jet_woo_builder_archive_id = $args['jet_woo_builder_archive_id'];

		if ( ! empty( $query_args['post__in'] ) ) {
			$query_args['post__in'] = explode( ',', $query_args['post__in'] );
		}

		if ( ! empty( $query_args['post__not_in'] ) ) {
			$query_args['post__not_in'] = explode( ',', $query_args['post__not_in'] );
		}

		if ( ! empty( $args['search'] ) ) {
			$query_args['s'] = esc_attr( $args['search'] );
		}

		if ( $args['items_type'] === 'jetengine_listing' ) {
			jet_engine()->frontend->set_listing( $args['jetengine_listing_id'] );
		}

		$query_args = apply_filters( 'posts-grid-builder/endpoints/posts/query_args', $query_args, $args );

		$query = new \WP_Query( $query_args );
		$posts = $query->posts;

		foreach ( $posts as &$post ) {
			setup_postdata( $GLOBALS['post'] = $post );

			if ( $post->post_type === 'product' ) {
				if ( $args['woo_items_type'] === 'jet_woo_builder_archive' ) {
					$prepared_post = $this->prepare_jet_woo_builder_listing_post( $post );
				} else {
					$prepared_post = $this->prepare_woo_post( $post );
				}
			} else {
				if ( $args['items_type'] === 'post_content' ) {
					$prepared_post = $this->prepare_post_content( $post );
				} else if ( $args['items_type'] === 'jetengine_listing' ) {
					$prepared_post = $this->prepare_jetengine_listing_post( $post );
				} else {
					$prepared_post = $this->prepare_post( $post );
				}
			}

			$post = apply_filters( 'posts-grid-builder/post-data', $prepared_post );
		}

		wp_reset_postdata();

		return rest_ensure_response( array(
			'page'  => (int)$query_args['paged'],
			'pages' => $query->max_num_pages,
			'posts' => $posts
		) );

	}

	public function prepare_post( $post ) {

		$thumb_id = get_post_thumbnail_id( $post->ID );
		$dates = date( $this->date_format, strtotime( $post->post_date ) );
		$type_object = get_post_type_object( $post->post_type );

		$prepared_post = array(
			'id'             => $post->ID,
			'permalink'      => get_permalink( $post->ID ),
			'thumbnail_data' => Plugin::instance()->get_thumbnail_data( $thumb_id, $this->thumbnail_size ),
			'post_title'     => $post->post_title,
			'post_date'      => $dates,
			'post_name'      => $post->post_name,
			'post_content'   => $post->post_content,
			'post_excerpt'   => $post->post_excerpt,
			'post_author'    => get_the_author_meta( 'display_name', $post->post_author ),
			'post_type'      => $type_object->labels->singular_name
		);

		return $prepared_post;

	}

	public function prepare_woo_post( $post ) {

		$product = wc_get_product( $post->ID );
		$prepared_post = $this->prepare_post( $post );
		$prepared_post['is_woocommerce'] = true;
		$prepared_post['woocommerce_rating_count'] = $product->get_rating_count();
		$prepared_post['woocommerce_average_rating'] = $product->get_average_rating();
		$prepared_post['woocommerce_add_to_cart_url'] = $product->add_to_cart_url();
		$prepared_post['woocommerce_price'] = $product->get_price_html();

		$terms = get_the_terms( $post->ID, 'product_cat' );
		if ( $terms ) {
			foreach ($terms as $term) {
				$prepared_post['woocommerce_product_cat'][] = array(
					'term_id'   => $term->term_id,
					'name'      => $term->name,
					'permalink' => get_term_link( $term->term_id, 'product_cat' )
				);
			}
		}

		return $prepared_post;

	}

	public function prepare_post_content( $post ) {

		$post_id  = $post->ID;
		$thumb_id = get_post_thumbnail_id( $post_id );

		if ( get_post_meta( $post_id, '_elementor_edit_mode', true ) ) {
			ob_start();

			Plugin::instance()->print_elementor_post_inline_css( $post_id );
			echo Elementor::instance()->frontend->get_builder_content_for_display( $post_id );

			$content = ob_get_clean();
		} else {
			$content = do_blocks( $post->post_content );
		}

		$prepared_post = array(
			'id'             => $post_id,
			'permalink'      => get_permalink( $post_id ),
			'thumbnail_data' => Plugin::instance()->get_thumbnail_data( $thumb_id, $this->thumbnail_size ),
			'content'        => $content
		);

		return $prepared_post;

	}

	public function prepare_jetengine_listing_post( $post ) {

		ob_start();
		echo jet_engine()->frontend->get_listing_item( $post );
		$content = ob_get_clean();

		$prepared_post = array(
			'id'      => $post->ID,
			'content' => $content
		);

		return $prepared_post;

	}

	public function prepare_jet_woo_builder_listing_post( $post ) {

		setup_postdata( $post );

		jet_woo_builder_integration_woocommerce()->maybe_enqueue_single_template_css();

		ob_start();

		if ( ! $this->jet_woo_builder_inline_css_added ) {
			Plugin::instance()->print_elementor_post_inline_css( $this->jet_woo_builder_archive_id );
			$this->jet_woo_builder_inline_css_added = true;
		}
		echo jet_woo_builder()->parser->get_template_content( $this->jet_woo_builder_archive_id );

		$content = ob_get_clean();

		$prepared_post = array(
			'id'             => $post->ID,
			'is_woocommerce' => true,
			'content'        => $content
		);

		return $prepared_post;

	}

}