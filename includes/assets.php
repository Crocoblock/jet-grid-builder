<?php
namespace Posts_Grid_Builder;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Assets class
 */
class Assets {

	public $script_suffix = '.min';

	/**
	 * Constructor for the class
	 */
	public function __construct() {

		if ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) {
			$script_suffix = '';
		}

		add_action( 'wp_enqueue_scripts', array( $this, 'plugin_assets' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'editor_assets' ) );
		add_action( 'enqueue_block_editor_assets', array( $this, 'block_editor_assets' ) );

	}

	/**
	 * Register plugin assets
	 *
	 * @return void
	 */
	public function plugin_assets() {

		// enqueue script polyfills for IE
		global $is_IE;
		wp_register_script(
			'jgb-polyfills',
			$is_IE ? Plugin::instance()->assets_url( 'js/polyfills.js' ) : false,
			array(),
			JET_GRID_BUILDER_VERSION
		);

		wp_register_style(
			'jgb-styles',
			Plugin::instance()->assets_url( 'css/jgb-styles.css' ),
			false,
			JET_GRID_BUILDER_VERSION
		);

		wp_register_script(
			'cx-vue',
			Plugin::instance()->assets_url( 'js/vendors/vue' . $this->script_suffix . '.js' ),
			array(),
			'2.6.10',
			true
		);

		if ( class_exists( '\Elementor\Plugin' ) ) {
			wp_register_script(
				'jgb-widgets-grid-builder-script',
				\Elementor\Plugin::$instance->preview->is_preview_mode()
					? Plugin::instance()->assets_url( 'js/widgets-grid-builder-editor.js' )
					: Plugin::instance()->assets_url( 'js/widgets-grid-builder-front.js' ),
				array(
					'elementor-frontend',
					'cx-vue'
				),
				JET_GRID_BUILDER_VERSION,
				true
			);

			if ( class_exists( 'Jet_Engine' ) ) {
				wp_enqueue_script( 'jquery-slick' );
				wp_enqueue_script( 'imagesloaded' );
			}

			wp_localize_script( 'jgb-widgets-grid-builder-script', 'jgbSettings', array(
				'api' => array(
					'endpoints' => Plugin::instance()->api->get_endpoints_urls(),
				),
			) );
		}

		wp_register_script(
			'jgb-blocks-grid-builder-script',
			Plugin::instance()->assets_url( 'js/blocks-grid-builder-front.js' ),
			array(
				'wp-blocks',
				'wp-editor',
				'jgb-polyfills',
				'cx-vue',
			),
			JET_GRID_BUILDER_VERSION,
			true
		);

		wp_localize_script( 'jgb-blocks-grid-builder-script', 'jgbSettings', array(
			'api' => array(
				'endpoints' => Plugin::instance()->api->get_endpoints_urls(),
			),
		) );

	}

	/**
	 * Enqueue plugin assets only for elementor editor
	 *
	 * @return void
	 */
	public function editor_assets() {

		wp_enqueue_style(
			'jgb-editor-styles',
			Plugin::instance()->assets_url( 'css/jgb-editor-styles.css' ),
			false,
			JET_GRID_BUILDER_VERSION
		);

		wp_register_script(
			'cx-vue',
			Plugin::instance()->assets_url( 'js/vendors/vue' . $this->script_suffix . '.js' ),
			array(),
			'2.6.10',
			true
		);

		wp_enqueue_script(
			'jgb-editor',
			Plugin::instance()->assets_url( 'js/editor.js' ),
			array(
				'elementor-editor',
				'cx-vue'
			),
			JET_GRID_BUILDER_VERSION,
			true
		);

		wp_localize_script( 'jgb-editor', 'jgbSettings', array(
			'api' => array(
				'endpoints' => Plugin::instance()->api->get_endpoints_urls(),
			),
		) );

	}

	/**
	 * Register blocks assets
	 *
	 * @return false
	 */
	public function block_editor_assets() {

		if ( Plugin::instance()->has_elementor() ) {
			$direction_suffix = is_rtl() ? '-rtl' : '';

			wp_enqueue_style(
				'elementor-frontend-legacy',
				ELEMENTOR_ASSETS_URL . 'css/frontend-legacy' . $direction_suffix . '.min.css',
				false,
				ELEMENTOR_VERSION
			);

			wp_enqueue_style(
				'elementor-frontend',
				ELEMENTOR_ASSETS_URL . 'css/frontend' . $direction_suffix . '.min.css',
				false,
				ELEMENTOR_VERSION
			);
		}

		wp_enqueue_style(
			'jgb-editor-styles',
			Plugin::instance()->assets_url( 'css/jgb-editor-styles.css' ),
			false,
			JET_GRID_BUILDER_VERSION
		);

		wp_enqueue_style(
			'jgb-styles',
			Plugin::instance()->assets_url( 'css/jgb-styles.css' ),
			false,
			JET_GRID_BUILDER_VERSION
		);

		wp_register_script(
			'cx-vue',
			Plugin::instance()->assets_url( 'js/vendors/vue' . $this->script_suffix . '.js' ),
			array(),
			'2.6.10',
			true
		);

		wp_enqueue_script(
			'jgb-blocks-grid-builder-script',
			Plugin::instance()->assets_url( 'js/blocks-grid-builder-editor.js' ),
			array('wp-blocks','wp-editor', 'wp-components', 'wp-i18n', 'cx-vue'),
			JET_GRID_BUILDER_VERSION,
			true
		);

		$localized_data = array(
			'api' => array(
				'endpoints' => Plugin::instance()->api->get_endpoints_urls(),
			),
			'plugins_exist' => array(
				'jetengine'     => class_exists( 'Jet_Engine' ),
				'woocommerce'   => class_exists( 'WooCommerce' ),
				'jetwoobuilder' => class_exists( 'Jet_Woo_Builder' ),
			),
			'blocks_options' => array(
				'items_type'      => Plugin::instance()->get_items_type_options(),
				'thumbnail_sizes' => Plugin::instance()->get_img_sizes()
			)
		);

		if ( class_exists( 'Jet_Engine' ) ) {
			$localized_data['blocks_options']['jetengine_listings'] = Plugin::instance()->get_jet_engine_listings_options();
		}

		if ( Plugin::instance()->has_elementor() && class_exists( 'WooCommerce' ) && class_exists( 'Jet_Woo_Builder' ) ) {
			$localized_data['blocks_options']['woo_items_types'] = Plugin::instance()->get_woo_items_type_options();
			$localized_data['blocks_options']['jetwoobuilder_listings'] = Plugin::instance()->get_jet_woo_builder_archive_options();
		}

		wp_localize_script( 'jgb-blocks-grid-builder-script', 'jgbSettings', $localized_data );

	}

}
