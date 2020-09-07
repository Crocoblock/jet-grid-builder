<?php
namespace Posts_Grid_Builder_Preview;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Assets class
 */
class Assets {

	/**
	 * Constructor for the class
	 */
	public function __construct() {

		add_action( 'wp_enqueue_scripts', array( $this, 'plugin_assets' ) );
		add_action( 'elementor/editor/after_enqueue_scripts', array( $this, 'editor_assets' ) );

	}

	/**
	 * Register plugin assets
	 *
	 * @return void
	 */
	public function plugin_assets() {

		if ( !class_exists( '\Elementor\Plugin' ) )
			return;

		// enqueue script polyfills for IE
		global $is_IE;
		if ($is_IE)
			wp_enqueue_script(
				'jgb-polyfills',
				Plugin::instance()->assets_url( 'js/polyfills.js' ),
				array(),
				JET_GRID_BUILDER_PREVIEW_VERSION
			);

		wp_register_style(
			'jgb-editor-styles-preview',
			Plugin::instance()->assets_url( 'css/jgb-editor-styles-preview.css' ),
			false,
			JET_GRID_BUILDER_PREVIEW_VERSION
		);

		wp_register_style(
			'jgb-styles-preview',
			Plugin::instance()->assets_url( 'css/jgb-styles-preview.css' ),
			array(
				'jgb-editor-styles-preview'
			),
			JET_GRID_BUILDER_PREVIEW_VERSION
		);

		wp_register_script(
			'vue',
			Plugin::instance()->assets_url( 'js/vendors/vue.min.js' ),
			array(),
			'2.5.17',
			true
		);

		wp_register_script(
			'jgb-posts-grid-builder-script-preview',
			\Elementor\Plugin::$instance->preview->is_preview_mode()
				? Plugin::instance()->assets_url( 'js/posts-grid-builder-editor.js' )
				: Plugin::instance()->assets_url( 'js/posts-grid-builder-front.js' ),
			array(
				'elementor-frontend',
				'vue'
			),
			JET_GRID_BUILDER_PREVIEW_VERSION,
			true
		);

		wp_register_script(
			'jgb-terms-grid-builder-script-preview',
			\Elementor\Plugin::$instance->preview->is_preview_mode()
				? Plugin::instance()->assets_url( 'js/terms-grid-builder-editor.js' )
				: Plugin::instance()->assets_url( 'js/terms-grid-builder-front.js' ),
			array(
				'elementor-frontend',
				'vue',
				'swiper'
			),
			JET_GRID_BUILDER_PREVIEW_VERSION,
			true
		);

		wp_localize_script( 'vue', 'jgbSettings', array(
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

		wp_register_script(
			'vue',
			Plugin::instance()->assets_url( 'js/vendors/vue.min.js' ),
			array(),
			'2.5.17',
			true
		);

		wp_enqueue_style(
			'jgb-editor-styles-preview',
			Plugin::instance()->assets_url( 'css/jgb-editor-styles-preview.css' ),
			false,
			JET_GRID_BUILDER_PREVIEW_VERSION
		);

		wp_enqueue_script(
			'jgb-editor-preview',
			Plugin::instance()->assets_url( 'js/editor.js' ),
			array(
				'elementor-editor',
				'vue'
			),
			JET_GRID_BUILDER_PREVIEW_VERSION,
			true
		);

		wp_localize_script( 'jgb-editor-preview', 'jgbSettings', array(
			'api' => array(
				'endpoints' => Plugin::instance()->api->get_endpoints_urls(),
			),
		) );

	}

}
