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
		return array( 'jgb-posts-grid-builder-script' );
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
			'layout-data',
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

	public function get_grid_settings() {

		$settings = $this->get_settings();
		$result   = array();

		// grid settings
		$result['posts']                               = isset( $settings['posts'] ) ? $settings['posts'] : '';
		$result['layout-data']                         = isset( $settings['layout-data'] ) ? $settings['layout-data'] : '';
		$result['layout-data_tablet']                  = isset( $settings['layout-data_tablet'] ) ? $settings['layout-data_tablet'] : '';
		$result['layout-data_mobile']                  = isset( $settings['layout-data_mobile'] ) ? $settings['layout-data_mobile'] : '';
		$result['colNum']                              = isset( $settings['colNum'] ) ? $settings['colNum'] : 24;
		$result['gutter']                              = isset( $settings['gutter'] ) ? $settings['gutter'] : 10;
		$result['gutter_tablet']                       = isset( $settings['gutter_tablet'] ) ? $settings['gutter_tablet'] : '';
		$result['gutter_mobile']                       = isset( $settings['gutter_mobile'] ) ? $settings['gutter_mobile'] : '';
		$result['vertical_compact']                    = isset( $settings['vertical_compact'] ) ? $settings['vertical_compact'] : 'no';
		$result['items_type']                          = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$result['woo_items_type']                      = isset( $settings['woo_items_type'] ) ? $settings['woo_items_type'] : 'default';
		$result['jetengine_listing_id']                = isset( $settings['jetengine_listing_id'] ) && 'jetengine_listing' === $settings['items_type'] ? esc_attr( $settings['jetengine_listing_id'] ) : false;
		$result['jet_woo_builder_archive_id']          = isset( $settings['jet_woo_builder_archive_id'] ) && 'jet_woo_builder_archive' === $settings['woo_items_type'] ? esc_attr( $settings['jet_woo_builder_archive_id'] ) : false;
		$result['loading_spinner']                     = isset( $settings['loading_spinner'] ) ? $settings['loading_spinner'] : 'true';
		$result['loading_spinner_media']               = isset( $settings['loading_spinner_media'] ) ? $settings['loading_spinner_media'] : '';

		// item settings
		$result['item_style']                          = isset( $settings['item_style'] ) ? $settings['item_style'] : 'default';
		$result['item_thumbnail']                      = isset( $settings['item_thumbnail'] ) ? $settings['item_thumbnail'] : 'true';
		$result['item_thumbnail_size']                 = isset( $settings['item_thumbnail_size'] ) ? $settings['item_thumbnail_size'] : 'large';
		$result['item_post_type']                      = isset( $settings['item_post_type'] ) ? $settings['item_post_type'] : 'true';
		$result['item_title']                          = isset( $settings['item_title'] ) ? $settings['item_title'] : 'true';
		$result['item_description']                    = isset( $settings['item_description'] ) ? $settings['item_description'] : 'true';
		$result['item_description_words_count']        = isset( $settings['item_description_words_count'] ) ? $settings['item_description_words_count'] : 15;
		$result['item_description_words_count_tablet'] = isset( $settings['item_description_words_count_tablet'] ) ? $settings['item_description_words_count_tablet'] : 15;
		$result['item_description_words_count_mobile'] = isset( $settings['item_description_words_count_mobile'] ) ? $settings['item_description_words_count_mobile'] : 15;
		$result['item_post_author']                    = isset( $settings['item_post_author'] ) ? $settings['item_post_author'] : 'true';
		$result['item_post_author_prefix']             = isset( $settings['item_post_author_prefix'] ) ? $settings['item_post_author_prefix'] : '';
		$result['item_post_date']                      = isset( $settings['item_post_date'] ) ? $settings['item_post_date'] : 'true';
		$result['item_post_date_prefix']               = isset( $settings['item_post_date_prefix'] ) ? $settings['item_post_date_prefix'] : '';
		$result['item_post_date_format']               = isset( $settings['item_post_date_format'] ) ? $settings['item_post_date_format'] : 'F, j';
		$result['item_divider']                        = isset( $settings['item_divider'] ) ? $settings['item_divider'] : 'true';

		// Woocommerce product settings
		$result['woocommerce_item_stars_rating']       = isset( $settings['woocommerce_item_stars_rating'] ) ? $settings['woocommerce_item_stars_rating'] : 'true';
		$result['woocommerce_item_categories']         = isset( $settings['woocommerce_item_categories'] ) ? $settings['woocommerce_item_categories'] : 'true';
		$result['woocommerce_item_price']              = isset( $settings['woocommerce_item_price'] ) ? $settings['woocommerce_item_price'] : 'true';
		$result['woocommerce_item_add_to_cart']        = isset( $settings['woocommerce_item_add_to_cart'] ) ? $settings['woocommerce_item_add_to_cart'] : 'true';
		$result['woocommerce_item_add_to_cart_text']   = isset( $settings['woocommerce_item_add_to_cart_text'] ) ? esc_attr( $settings['woocommerce_item_add_to_cart_text'] ) : 'Add to cart';

		$result = apply_filters( 'posts-grid-builder/data-settings', $result );

		return json_encode( $result );

	}

	protected function render() {

		$settings        = $this->get_settings();
		$items_type      = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$item_style      = isset( $settings['item_style'] ) ? $settings['item_style'] : 'default';
		$woo_items_type  = isset( $settings['woo_items_type'] ) ? $settings['woo_items_type'] : 'default';
		$woo_item_style  = isset( $settings['woo_item_style'] ) ? $settings['woo_item_style'] : 'default';
		$loading_spinner = filter_var( $settings['loading_spinner'], FILTER_VALIDATE_BOOLEAN );
		$container_class = 'jgb_posts-grid-builder-container';

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
			include Plugin::instance()->get_template( 'widgets/posts-grid-builder-widget.php' );
			if ( $loading_spinner ) {
				include Plugin::instance()->get_template( 'common-elements/loading-spinner.php' );
			}

		echo "</div>";

	}

}
