<?php
namespace Posts_Grid_Builder\Widgets;

use Posts_Grid_Builder\Plugin;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Builder_Terms extends \Elementor\Widget_Base {

	public function get_name() {
		return 'terms-grid-builder';
	}

	public function get_title() {
		return esc_html__( 'Terms Grid Builder', 'jet-grid-builder' );
	}

	public function get_icon() {
		return 'eicon-inner-section';
	}

	public function get_categories() {
		return array( 'jet-grid-builder' );
	}

	public function get_script_depends() {
		return array( 'jgb-widgets-grid-builder-script' );
	}

	public function get_style_depends() {
		return array( 'jgb-styles' );
	}

	protected function _register_controls() {
		// Grid Settings
		$this->start_controls_section(
			'grid_section',
			[
				'label' => esc_html__( 'Grid', 'jet-grid-builder' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'layout_data',
			[
				'type'        => \Elementor\Controls_Manager::HIDDEN,
				'render_type' => 'none'
			]
		);

		$this->add_control(
			'terms',
			[
				'label'       => esc_html__( 'Terms', 'jet-grid-builder' ),
				'type'        => \Elementor\Controls_Manager::BUTTON,
				'text'        => '<i class="eicon-plus"></i>' . esc_html__( 'Add Terms', 'jet-grid-builder' ),
				'event'       => 'jgb:term:add',
				'render_type' => 'none'
			]
		);

		$this->add_control(
			'vertical_compact',
			[
				'label'        => esc_html__( 'Vertical Compact', 'jet-grid-builder' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'True', 'jet-grid-builder' ),
				'label_off'    => esc_html__( 'False', 'jet-grid-builder' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
				'render_type'  => 'none'
			]
		);

		$this->add_responsive_control(
			'gutter',
			[
				'label'       => esc_html__( 'Gutter', 'jet-grid-builder' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 0,
				'max'         => 50,
				'step'        => 1,
				'default'     => 10,
				'render_type' => 'none'
			]
		);

		$this->add_control(
			'colNum',
			[
				'label'       => esc_html__( 'Number of columns', 'jet-grid-builder' ),
				'type'        => \Elementor\Controls_Manager::NUMBER,
				'min'         => 3,
				'max'         => 50,
				'step'        => 1,
				'default'     => 24,
				'render_type' => 'none'
			]
		);

		if ( class_exists( 'Jet_Engine' ) ) {

			$this->add_control(
				'items_type',
				array(
					'label'   => __( 'Items Type', 'jet-grid-builder' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default'           => esc_html__( 'Default', 'jet-grid-builder' ),
						'jetengine_listing' => esc_html__( 'Jetengine Listing', 'jet-grid-builder' ),
					]
				)
			);

			$this->add_control(
				'jetengine_listing_id',
				array(
					'label'     => __( 'Listing', 'jet-grid-builder' ),
					'type'      => \Elementor\Controls_Manager::SELECT,
					'default'   => '',
					'options'   => Plugin::instance()->get_jet_engine_listings_options(),
					'condition' => [
						'items_type' => 'jetengine_listing'
					]
				)
			);

		} else {

			$this->add_control(
				'items_type',
				[
					'type'    => \Elementor\Controls_Manager::HIDDEN,
					'default' => 'default'
				]
			);

		}

		// Include Loading Spinner Controls
		include Plugin::instance()->get_controls( 'loading/loading-spinner-controls.php' );

		$this->end_controls_section();

		// Include Term Item Settings
		include Plugin::instance()->get_controls( 'term-item/term-item-settings.php' );

		// Include Term Item Style
		include Plugin::instance()->get_controls( 'term-item/term-item-style.php' );

		// Include Term Item: Content Body Style
		include Plugin::instance()->get_controls( 'term-item/term-item-content-body-style.php' );

		// Include Term Item: Title Style
		include Plugin::instance()->get_controls( 'term-item/term-item-title-style.php' );

		// Include Term Item: Description Style
		include Plugin::instance()->get_controls( 'term-item/term-item-description-style.php' );

		// Include Term Item: Posts Count Style
		include Plugin::instance()->get_controls( 'term-item/term-item-posts-count-style.php' );

		// Include Term Item: Divider Style
		include Plugin::instance()->get_controls( 'term-item/term-item-divider-style.php' );

		// Include Term Item: Type Label Style
		include Plugin::instance()->get_controls( 'term-item/term-item-type-label-style.php' );

		// Include Term Item Order Style
		include Plugin::instance()->get_controls( 'term-item/term-item-order-style.php' );

		// Include Loading Spinner Style
		include Plugin::instance()->get_controls( 'loading/loading-spinner-style.php' );

	}

	protected function render() {

		$settings        = $this->get_settings();
		$items_type      = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$loading_spinner = filter_var( $settings['loading_spinner'], FILTER_VALIDATE_BOOLEAN );
		$container_class = 'jgb_terms-grid-builder-container';

		if ( class_exists( 'Jet_Engine' ) ) {
			wp_enqueue_script( 'jquery-slick' );
			wp_enqueue_script( 'imagesloaded' );
		}

		if ( $items_type === 'jetengine_listing' && !$settings['jetengine_listing_id'] ) {
			printf(
				'<div class="jgb_notice">%s</div>',
				__( 'Please choose JetEngine listing', 'jet-grid-builder' )
			);

			return;
		}

		echo "<div class='$container_class'>";
			Plugin::instance()->include_item_template_by_type( $items_type, 'term' );

			echo '<div class="terms-grid-builder" id="inst_' . esc_attr( $this->get_id() ) . '" data-settings="' . htmlspecialchars( Plugin::instance()->get_grid_builder_terms_settings( $settings ) ) .'"></div>';

			if ( $loading_spinner ) include Plugin::instance()->get_template( 'common-elements/loading-spinner.php' );
		echo "</div>";

	}

}
