<?php
namespace Posts_Grid_Builder;

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Define Elementor_Manager class
 */
class Elementor_Manager {

	/**
	 * Initalize integration hooks
	 *
	 * @return void
	 */
	public function __construct() {

		add_action( 'elementor/widgets/widgets_registered', array( $this, 'register_widgets' ), 10 );
		add_action( 'elementor/init', array( $this, 'register_category' ) );

	}

	/**
	 * Register plugin widgets
	 *
	 * @param  object $widgets_manager Elementor widgets manager instance.
	 * @return void
	 */
	public function register_widgets( $widgets_manager ) {
		$widgets = array(
			new Widgets\Grid_Builder(),
			new Widgets\Grid_Builder_Terms()
		);

		foreach ( $widgets as $widget ) {
			$widgets_manager->register_widget_type( $widget );
		}
	}

	/**
	 * Register cherry category for elementor if not exists
	 *
	 * @return void
	 */
	public function register_category() {

		$elements_manager = \Elementor\Plugin::instance()->elements_manager;
		$cat              = 'jet-grid-builder';

		$elements_manager->add_category(
			$cat,
			array(
				'title' => esc_html__( 'Jet Grid Builder', 'jet-grid-builder' ),
				'icon'  => 'font',
			),
			1
		);
	}
}
