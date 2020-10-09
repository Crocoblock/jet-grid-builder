<?php
namespace Posts_Grid_Builder\Widgets;

use Posts_Grid_Builder\Plugin;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Builder extends \Elementor\Widget_Base {

	public function get_name() {
		return 'posts-grid-builder';
	}

	public function get_title() {
		return esc_html__( 'Posts Grid Builder', 'jet-grid-builder' );
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
			'posts',
			[
				'label'       => esc_html__( 'Posts', 'jet-grid-builder' ),
				'type'        => \Elementor\Controls_Manager::BUTTON,
				'text'        => '<i class="eicon-plus"></i>' . esc_html__( 'Add Posts', 'jet-grid-builder' ),
				'event'       => 'jgb:post:add',
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

		$this->add_control(
			'items_type',
			array(
				'label'   => __( 'Items Type', 'jet-grid-builder' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'default',
				'options' => Plugin::instance()->get_items_type_options(),
			)
		);

		if ( class_exists( 'Jet_Engine' ) ) {

			$this->add_control(
				'jetengine_listing_id',
				array(
					'label'   => __( 'Listing', 'jet-grid-builder' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => '',
					'options' => Plugin::instance()->get_jet_engine_listings_options(),
					'condition' => [
						'items_type' => 'jetengine_listing'
					]
				)
			);

		}

		$this->add_control(
			'item_style',
			[
				'label'   => esc_html__( 'Item Style', 'jet-grid-builder' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'options' => [
					'default'         => esc_html__( 'Standard', 'jet-grid-builder' ),
					'content-overlay' => esc_html__( 'Content Overlay', 'jet-grid-builder' )
				],
				'default' => 'default',
				'condition' => [
					'items_type' => 'default'
				]
			]
		);

		if ( class_exists( 'WooCommerce' ) ) {

			if ( class_exists( 'Jet_Woo_Builder' ) ) {

				$this->add_control(
					'woo_items_type',
					array(
						'label'   => __( 'Woo Items Type', 'jet-grid-builder' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'default' => 'default',
						'options' => Plugin::instance()->get_woo_items_type_options(),
					)
				);

				$this->add_control(
					'jet_woo_builder_archive_id',
					array(
						'label'   => __( 'JetWooBuilder Template', 'jet-grid-builder' ),
						'type'    => \Elementor\Controls_Manager::SELECT,
						'default' => '',
						'options' => Plugin::instance()->get_jet_woo_builder_archive_options(),
						'condition' => [
							'woo_items_type' => 'jet_woo_builder_archive'
						]
					)
				);

			} else {

				$this->add_control(
					'woo_items_type',
					[
						'type'    => \Elementor\Controls_Manager::HIDDEN,
						'default' => 'default'
					]
				);

			}

			$this->add_control(
				'woo_item_style',
				[
					'label'   => esc_html__( 'Woo Item Style', 'jet-grid-builder' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'options' => [
						'default'         => esc_html__( 'Standard', 'jet-grid-builder' ),
						'content-overlay' => esc_html__( 'Content Overlay', 'jet-grid-builder' )
					],
					'default' => 'default',
					'condition' => [
						'woo_items_type' => 'default'
					]
				]
			);

		}

		// Include Loading Spinner Controls
		include Plugin::instance()->get_controls( 'loading/loading-spinner-controls.php' );

		$this->end_controls_section();

		// Include Post Item Settings
		include Plugin::instance()->get_controls( 'post-item/post-item-settings.php' );

		// Include Woocommerce Product Settings
		include Plugin::instance()->get_controls( 'woocommerce/woocommerce-product-settings.php' );

		// Include Post Item Style
		include Plugin::instance()->get_controls( 'post-item/post-item-style.php' );

		// Include Post Item: Content Body Style
		include Plugin::instance()->get_controls( 'post-item/post-item-content-body-style.php' );

		// Include Post Item: Title Style
		include Plugin::instance()->get_controls( 'post-item/post-item-title-style.php' );

		// Include Post Item: Description Style
		include Plugin::instance()->get_controls( 'post-item/post-item-description-style.php' );

		// Include Post Item: Meta Style
		include Plugin::instance()->get_controls( 'post-item/post-item-meta-style.php' );

		// Include Post Item: Divider Style
		include Plugin::instance()->get_controls( 'post-item/post-item-divider-style.php' );

		// Include Post Item: Type Label Style
		include Plugin::instance()->get_controls( 'post-item/post-item-type-label-style.php' );

		// Include Woocommerce Product Style
		include Plugin::instance()->get_controls( 'woocommerce/woocommerce-product-style.php' );

		// Include Post Item Order Style
		include Plugin::instance()->get_controls( 'post-item/post-item-order-style.php' );

		// Include Loading Spinner Style
		include Plugin::instance()->get_controls( 'loading/loading-spinner-style.php' );

	}

	protected function render() {

		$settings        = $this->get_settings();
		$items_type      = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$item_style      = isset( $settings['item_style'] ) ? $settings['item_style'] : 'default';
		$woo_items_type  = isset( $settings['woo_items_type'] ) ? $settings['woo_items_type'] : 'default';
		$woo_item_style  = isset( $settings['woo_item_style'] ) ? $settings['woo_item_style'] : 'default';
		$loading_spinner = filter_var( $settings['loading_spinner'], FILTER_VALIDATE_BOOLEAN );
		$container_class = 'jgb_posts-grid-builder-container';

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

		if ( $woo_items_type === 'jet_woo_builder_archive' && !$settings['jet_woo_builder_archive_id'] ) {
			printf(
				'<div class="jgb_notice">%s</div>',
				__( 'Please choose JetWooBuilder archive template', 'jet-grid-builder' )
			);

			return;
		}

		echo "<div class='$container_class'>";

			Plugin::instance()->include_item_template_by_type( $items_type, $item_style );
			Plugin::instance()->include_woo_item_template_by_type( $woo_items_type, $woo_item_style );

			echo '<div class="posts-grid-builder" id="inst_' . esc_attr( $this->get_id() ) . '" data-settings="' . htmlspecialchars( Plugin::instance()->get_grid_builder_settings( $settings ) ) .'"></div>';

			if ( $loading_spinner ) {
				include Plugin::instance()->get_template( 'common-elements/loading-spinner.php' );
			}

		echo "</div>";

	}

}
