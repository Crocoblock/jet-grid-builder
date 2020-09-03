<?php
namespace Posts_Grid_Builder_Preview\Widgets;

use Posts_Grid_Builder_Preview\Plugin;


if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class Grid_Builder_Terms extends \Elementor\Widget_Base {

	public function get_name() {
		return 'terms-grid-builder-preview';
	}

	public function get_title() {
		return esc_html__( 'Terms Grid Builder Preview', 'jet-grid-builder-preview' );
	}

	public function get_icon() {
		return 'eicon-inner-section';
	}

	public function get_categories() {
		return array( 'jet-grid-builder-preview' );
	}

	public function get_script_depends() {
		return array( 'jgb-terms-grid-builder-script-preview' );
	}

	public function get_style_depends() {
		return array( 'jgb-styles-preview' );
	}

	protected function _register_controls() {
		// Grid Settings
		$this->start_controls_section(
			'grid_section',
			[
				'label' => esc_html__( 'Grid', 'jet-grid-builder-preview' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_responsive_control(
			'layout-data',
			[
				'type'        => \Elementor\Controls_Manager::HIDDEN,
				'render_type' => 'none'
			]
		);

		$this->add_control(
			'terms',
			[
				'label'       => esc_html__( 'Terms', 'jet-grid-builder-preview' ),
				'type'        => \Elementor\Controls_Manager::BUTTON,
				'text'        => '<i class="eicon-plus"></i>' . esc_html__( 'Add Terms', 'jet-grid-builder-preview' ),
				'event'       => 'jgb:term:add',
				'render_type' => 'none'
			]
		);

		$this->add_control(
			'vertical_compact',
			[
				'label'        => esc_html__( 'Vertical Compact', 'jet-grid-builder-preview' ),
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'True', 'jet-grid-builder-preview' ),
				'label_off'    => esc_html__( 'False', 'jet-grid-builder-preview' ),
				'return_value' => 'yes',
				'default'      => 'no',
				'separator'    => 'before',
				'render_type'  => 'none'
			]
		);

		$this->add_responsive_control(
			'gutter',
			[
				'label'       => esc_html__( 'Gutter', 'jet-grid-builder-preview' ),
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
				'label'       => esc_html__( 'Number of columns', 'jet-grid-builder-preview' ),
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
					'label'   => __( 'Items Type', 'jet-grid-builder-preview' ),
					'type'    => \Elementor\Controls_Manager::SELECT,
					'default' => 'default',
					'options' => [
						'default'           => esc_html__( 'Default', 'jet-grid-builder-preview' ),
						'jetengine_listing' => esc_html__( 'Jetengine Listing', 'jet-grid-builder-preview' ),
					]
				)
			);

			$this->add_control(
				'jetengine_listing_id',
				array(
					'label'     => __( 'Listing', 'jet-grid-builder-preview' ),
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

	public function get_grid_settings() {

		$settings = $this->get_settings();
		$result   = array();

		// grid settings
		$result['terms']                               = isset( $settings['terms'] ) ? $settings['terms'] : '';
		$result['layout-data']                         = isset( $settings['layout-data'] ) ? $settings['layout-data'] : '';
		$result['layout-data_tablet']                  = isset( $settings['layout-data_tablet'] ) ? $settings['layout-data_tablet'] : '';
		$result['layout-data_mobile']                  = isset( $settings['layout-data_mobile'] ) ? $settings['layout-data_mobile'] : '';
		$result['colNum']                              = isset( $settings['colNum'] ) ? $settings['colNum'] : 24;
		$result['gutter']                              = isset( $settings['gutter'] ) ? $settings['gutter'] : 10;
		$result['gutter_tablet']                       = isset( $settings['gutter_tablet'] ) ? $settings['gutter_tablet'] : '';
		$result['gutter_mobile']                       = isset( $settings['gutter_mobile'] ) ? $settings['gutter_mobile'] : '';
		$result['vertical_compact']                    = isset( $settings['vertical_compact'] ) ? $settings['vertical_compact'] : 'no';
		$result['items_type']                          = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$result['jetengine_listing_id']                = isset( $settings['jetengine_listing_id'] ) && 'jetengine_listing' === $settings['items_type'] ? esc_attr( $settings['jetengine_listing_id'] ) : false;
		$result['loading_spinner']                     = isset( $settings['loading_spinner'] ) ? $settings['loading_spinner'] : 'true';
		$result['loading_spinner_media']               = isset( $settings['loading_spinner_media'] ) ? $settings['loading_spinner_media'] : '';

		// item settings
		$result['item_thumbnail']                      = isset( $settings['item_thumbnail'] ) ? $settings['item_thumbnail'] : 'true';
		$result['item_thumbnail_size']                 = isset( $settings['item_thumbnail_size'] ) ? $settings['item_thumbnail_size'] : 'large';
		$result['item_term_taxonomy']                  = isset( $settings['item_term_taxonomy'] ) ? $settings['item_term_taxonomy'] : 'true';
		$result['item_title']                          = isset( $settings['item_title'] ) ? $settings['item_title'] : 'true';
		$result['item_description']                    = isset( $settings['item_description'] ) ? $settings['item_description'] : 'true';
		$result['item_description_words_count']        = isset( $settings['item_description_words_count'] ) ? $settings['item_description_words_count'] : 15;
		$result['item_description_words_count_tablet'] = isset( $settings['item_description_words_count_tablet'] ) ? $settings['item_description_words_count_tablet'] : 15;
		$result['item_description_words_count_mobile'] = isset( $settings['item_description_words_count_mobile'] ) ? $settings['item_description_words_count_mobile'] : 15;
		$result['item_post_count']                     = isset( $settings['item_post_count'] ) ? $settings['item_post_count'] : 'true';
		$result['item_posts_count_prefix']             = isset( $settings['item_posts_count_prefix'] ) ? $settings['item_posts_count_prefix'] : '';
		$result['item_divider']                        = isset( $settings['item_divider'] ) ? $settings['item_divider'] : 'true';

		$result = apply_filters( 'terms-grid-builder/data-settings', $result );

		return json_encode( $result );

		if ( $items_type === 'jetengine_listing' && !$settings['jetengine_listing_id'] ) {
			printf(
				'<div class="jgb_notice">%s</div>',
				__( 'Please choose JetEngine listing', 'jet-grid-builder-preview' )
			);

			return;
		}

	}

	protected function render() {

		$settings        = $this->get_settings();
		$items_type      = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$loading_spinner = filter_var( $settings['loading_spinner'], FILTER_VALIDATE_BOOLEAN );
		$container_class = 'jgb_terms-grid-builder-container';

		if ( $items_type === 'jetengine_listing' && !$settings['jetengine_listing_id'] ) {
			printf(
				'<div class="jgb_notice">%s</div>',
				__( 'Please choose JetEngine listing', 'jet-grid-builder-preview' )
			);

			return;
		}

		echo "<div class='$container_class'>";
			Plugin::instance()->include_item_template_by_type( $items_type, 'term' );
			include Plugin::instance()->get_template( 'widgets/terms-grid-builder.php' );
			if ( $loading_spinner ) include Plugin::instance()->get_template( 'common-elements/loading-spinner.php' );
		echo "</div>";

	}

}
