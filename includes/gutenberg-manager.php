<?php
namespace Posts_Grid_Builder;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Gutenberg_Manager class
 */
class Gutenberg_Manager {

	/**
	 * Initalize integration hooks
	 *
	 * @return void
	 */
	public function __construct() {

		$this->register_block_types();

	}

	/**
	 * Register block types
	 *
	 * @return false
	 */
	public function register_block_types() {

		$blocks_dir = Plugin::instance()->plugin_path( 'includes/blocks/' );

		require $blocks_dir . 'grid-builder.php';
		require $blocks_dir . 'grid-builder-terms.php';

		new Blocks\Grid_Builder();
		new Blocks\Grid_Builder_Terms();

	}
}
