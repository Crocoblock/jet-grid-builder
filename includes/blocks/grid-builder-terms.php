<?php
namespace Posts_Grid_Builder\Blocks;

use Posts_Grid_Builder\Plugin;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Builder_Terms {

	protected $namespace = 'jet-grid-builder/';

	public function __construct() {

		$attributes = $this->get_attributes();

		register_block_type( 'jet-grid-builder/terms-grid-builder', array(
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
		return 'terms-grid-builder';
	}

	/**
	 * Return attributes array
	 *
	 * @return array
	 */
	public function get_attributes() {
		return array(
			'terms' => array(
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
				'type'    => 'boolean',
				'default' => true,
			),
			'item_description_words_count' => array(
				'type'    => 'number',
				'default' => 15,
			),
			'item_post_count' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'item_posts_count_prefix' => array(
				'type'    => 'string',
				'default' => __( 'Posts Count:', 'jet-grid-builder' ),
			),
			'item_divider' => array(
				'type'    => 'boolean',
				'default' => true,
			),
			'item_term_taxonomy' => array(
				'type'    => 'boolean',
				'default' => true,
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
		$loading_spinner = $settings['loading_spinner'];
		$container_class = 'jgb_terms-grid-builder-container jgb_block';

		ob_start();

		if ( $items_type === 'jetengine_listing' && !$settings['jetengine_listing_id'] ) {
			printf(
				'<div class="jgb_notice">%s</div>',
				__( 'Please choose JetEngine listing', 'jet-grid-builder' )
			);
		} else {
			echo "<div class='$container_class'>";
				Plugin::instance()->include_item_template_by_type( $items_type, 'term' );

				echo '<div class="terms-grid-builder" data-settings="' . htmlspecialchars( Plugin::instance()->get_grid_builder_terms_settings( $settings ) ) .'">TermsGridBuilder Block Loading...</div>';

				if ( $loading_spinner ) {
					include Plugin::instance()->get_template( 'common-elements/loading-spinner.php' );
				}
			echo "</div>";
		}

		$layout = ob_get_clean();

		return $layout;

	}

}