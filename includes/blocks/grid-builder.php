<?php
namespace Posts_Grid_Builder\Blocks;

use Posts_Grid_Builder\Plugin;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Builder {

	protected $namespace = 'jet-grid-builder/';

	public function __construct() {

		$attributes = $this->get_attributes();

		register_block_type( 'jet-grid-builder/posts-grid-builder', array(
			'attributes'      => $attributes,
			'render_callback' => array( $this, 'render_callback' ),
			'script'          => 'jgb-blocks-grid-builder-script',
			'style'           => 'jgb-styles',
		) );
	}

	/**
	 * Returns block name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'posts-grid-builder';
	}

	/**
	 * Return attributes array
	 *
	 * @return array
	 */
	public function get_attributes() {
		return array(
			'posts' => array(
				'type'    => 'string',
				'default' => '',
			),
			'layout_data' => array(
				'type'    => 'string',
				'default' => '',
			),
			'colNum' => array(
				'type'    => 'number',
				'default' => 18,
			),
			'gutter' => array(
				'type'    => 'number',
				'default' => 10,
			),
			'vertical_compact' => array(
				'type'    => 'boolean',
				'default' => false,
			),
			// item type
			'items_type' => array(
				'type'    => 'string',
				'default' => 'default',
			),
			'item_style' => array(
				'type'    => 'string',
				'default' => 'default',
			),
			'jetengine_listing_id' => array(
				'type'    => 'string',
				'default' => '',
			),
			// item 'default' settings
			'item_title' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'item_thumbnail' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'item_thumbnail_size' => array(
				'type'    => 'string',
				'default' => 'large',
			),
			'item_description' => array(
				'type'    => 'string',
				'default' => 'auto',
			),
			'item_description_words_count' => array(
				'type'    => 'number',
				'default' => 15,
			),
			'item_post_author' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'item_post_author_prefix' => array(
				'type'    => 'string',
				'default' => __( 'By', 'jet-grid-builder' ),
			),
			'item_post_date' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'item_post_date_prefix' => array(
				'type'    => 'string',
				'default' => __( 'Posted', 'jet-grid-builder' ),
			),
			'item_post_date_format' => array(
				'type'    => 'string',
				'default' => 'F, j',
			),
			'item_divider' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'item_post_type' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			// Woocommerce
			'woo_items_type' => array(
				'type'    => 'string',
				'default' => 'default',
			),
			'woo_item_style' => array(
				'type'    => 'string',
				'default' => 'default',
			),
			'jet_woo_builder_archive_id' => array(
				'type'    => 'string',
				'default' => '',
			),
			// Woocommerce settings
			'woocommerce_item_stars_rating' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'woocommerce_item_categories' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'woocommerce_item_price' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'woocommerce_item_add_to_cart' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'woocommerce_item_add_to_cart_text' => array(
				'type'    => 'string',
				'default' => __( 'Add to cart', 'jet-grid-builder' ),
			),
			// loading spinner settings
			'loading_spinner' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'loading_spinner_media' => array(
				'type'    => 'boolean',
				'default' => false,
			),
			'loading_spinner_type' => array(
				'type'    => 'string',
				'default' => 'circle-clip-growing',
			)
		);
	}

	/**
	 * Is editor context
	 *
	 * @return boolean
	 */
	public function is_editor() {

		return isset( $_REQUEST['context'] ) && $_REQUEST['context'] === 'edit' ? true : false;

	}

	/**
	 * Return callback
	 *
	 * @return html
	 */
	public function render_callback( $settings = array() ) {

		$items_type      = $settings['items_type'];
		$item_style      = $settings['item_style'];
		$woo_items_type  = $settings['woo_items_type'];
		$woo_item_style  = $settings['woo_item_style'];
		$loading_spinner = $settings['loading_spinner'];
		$container_class = 'jgb_posts-grid-builder-container jgb_block';

		ob_start();

		if ( ( $items_type === 'jetengine_listing' && !$settings['jetengine_listing_id'] ) || ( $woo_items_type === 'jet_woo_builder_archive' && $settings['jet_woo_builder_archive_id'] ) ) {
			wp_enqueue_style( 'elementor-frontend' );
		}

		if ( $items_type === 'jetengine_listing' && !$settings['jetengine_listing_id'] ) {
			printf(
				'<div class="jgb_notice">%s</div>',
				__( 'Please choose JetEngine listing', 'jet-grid-builder' )
			);
		} else if ( $woo_items_type === 'jet_woo_builder_archive' && !$settings['jet_woo_builder_archive_id'] ) {
			printf(
				'<div class="jgb_notice">%s</div>',
				__( 'Please choose JetWooBuilder archive template', 'jet-grid-builder' )
			);
		} else {
			echo "<div class='$container_class'>";
				Plugin::instance()->include_item_template_by_type( $items_type, $item_style );
				Plugin::instance()->include_woo_item_template_by_type( $woo_items_type, $woo_item_style );

				echo '<div class="posts-grid-builder" data-settings="' . htmlspecialchars( Plugin::instance()->get_grid_builder_settings( $settings ) ) .'">PostsGridBuilder Block Loading...</div>';

				if ( $loading_spinner ) {
					include Plugin::instance()->get_template( 'common-elements/loading-spinner.php' );
				}
			echo "</div>";
		}

		$layout = ob_get_clean();

		return $layout;

	}

}