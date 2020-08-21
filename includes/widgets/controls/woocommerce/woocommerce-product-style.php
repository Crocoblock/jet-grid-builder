<?php
/**
 * Woocommerce product style controls
 */

if ( class_exists( 'WooCommerce' ) ) {
	$this->start_controls_section(
		'woocommerce_style_section',
		[
			'label'      => esc_html__( 'Woocommerce Product', 'jet-grid-builder' ),
			'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
			'show_label' => false,
			'condition' => [
				'woo_items_type' => 'default'
			]
		]
	);

	$this->add_responsive_control(
		'woocommerce_thumbnail_margin',
		[
			'label'      => esc_html__( 'Thumbnail Offset', 'jet-grid-builder' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'selectors'  => [
				'{{WRAPPER}} .jgb_woocommerce-item .jgb_item-thumb' => 'border-top-width: {{TOP}}px; border-right-width: {{RIGHT}}px; border-bottom-width: {{BOTTOM}}px; border-left-width: {{LEFT}}px;',
			],
		]
	);

	$this->start_controls_tabs( 'woocommerce_title_tabs' );

	$this->start_controls_tab(
		'woocommerce_title_normal',
		[
			'label' => __( 'Normal', 'jet-grid-builder' ),
		]
	);

	$this->add_control(
		'woocommerce_title_color',
		[
			'label'  => esc_html__( 'Title Color', 'jet-grid-builder' ),
			'type'   => \Elementor\Controls_Manager::COLOR,
			'scheme' => [
				'type'  => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}} .jgb_woocommerce-item .jgb_item-title a' => 'color: {{VALUE}};',
			],
		]
	);

	$this->end_controls_tab();

	$this->start_controls_tab(
		'woocommerce_title_hover',
		[
			'label' => __( 'Hover', 'jet-grid-builder' ),
		]
	);

	$this->add_control(
		'woocommerce_title_hover_color',
		[
			'label'     => esc_html__( 'Title Color', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .jgb_woocommerce-item .jgb_item-title a:hover' => 'color: {{VALUE}};',
			],
		]
	);

	$this->end_controls_tab();

	$this->end_controls_tabs();

	$this->add_control(
		'woocommerce_stars_rating_controls',
		[
			'label'     => __( 'Woocommerce Stars Rating Options', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);

	$this->add_responsive_control(
		'woocommerce_stars_rating_margin',
		[
			'label'      => esc_html__( 'Stars Margin', 'jet-grid-builder' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .jgb_product-stars-rating' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_control(
		'woocommerce_stars_rating_color',
		[
			'label'     => esc_html__( 'Stars Color', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-stars-rating-star' => 'color: {{VALUE}};',
			],
		]
	);

	$this->add_control(
		'woocommerce_stars_rating_size',
		[
			'label' => esc_html__( 'Stars Size', 'jet-grid-builder' ),
			'type'  => \Elementor\Controls_Manager::SLIDER,
			'range' => [
				'px' => [
					'max'  => 100,
					'min'  => 1,
					'step' => 1,
				],
			],
			'selectors' => [
				'{{WRAPPER}} .jgb_product-stars-rating-star' => 'font-size: {{SIZE}}{{UNIT}};',
			]
		]
	);

	$this->add_responsive_control(
		'woocommerce_stars_rating_align',
		[
			'label'   => esc_html__( 'Alignment', 'jet-grid-builder' ),
			'type'    => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Left', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-center',
				],
				'flex-end' => [
					'title' => esc_html__( 'Right', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-right',
				],
			],
			'default'   => 'flex-end',
			'selectors' => [
				'{{WRAPPER}} .jgb_product-stars-rating' => 'justify-content: {{VALUE}};',
			],
		]
	);
	
	$this->add_control(
		'woocommerce_categories_controls',
		[
			'label'     => __( 'Woocommerce Categories Options', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);

	$this->add_responsive_control(
		'woocommerce_categories_margin',
		[
			'label'      => esc_html__( 'Categories Margin', 'jet-grid-builder' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .jgb_product-categories' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'label'    => esc_html__( 'Categories Typography', 'jet-grid-builder' ),
			'name'     => 'woocommerce_categories_typography',
			'selector' => '{{WRAPPER}} .jgb_product-category',
		]
	);

	$this->start_controls_tabs( 'woocommerce_categories_tabs' );

	$this->start_controls_tab(
		'woocommerce_categories_normal',
		[
			'label' => __( 'Normal', 'jet-grid-builder' ),
		]
	);

	$this->add_control(
		'woocommerce_categories_color',
		[
			'label'     => esc_html__( 'Color', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-category' => 'color: {{VALUE}};',
			],
		]
	);

	$this->end_controls_tab();

	$this->start_controls_tab(
		'woocommerce_categories_hover',
		[
			'label' => __( 'Hover', 'jet-grid-builder' ),
		]
	);

	$this->add_control(
		'woocommerce_categories_hover_color',
		[
			'label'  => esc_html__( 'Color', 'jet-grid-builder' ),
			'type'   => \Elementor\Controls_Manager::COLOR,
			'scheme' => [
				'type'  => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}} .jgb_product-category:hover' => 'color: {{VALUE}};',
			],
		]
	);

	$this->end_controls_tab();

	$this->end_controls_tabs();

	$this->add_responsive_control(
		'woocommerce_categories_align',
		[
			'label'   => esc_html__( 'Alignment', 'jet-grid-builder' ),
			'type'    => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [
					'title' => esc_html__( 'Left', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-center',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-right',
				],
			],
			'selectors' => [
				'{{WRAPPER}} .jgb_product-categories' => 'text-align: {{VALUE}};',
			],
		]
	);

	$this->add_control(
		'woocommerce_price_controls',
		[
			'label'     => __( 'Woocommerce Price Options', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);

	$this->add_responsive_control(
		'woocommerce_price_margin',
		[
			'label'      => esc_html__( 'Price Margin', 'jet-grid-builder' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .jgb_product-price' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'label'    => esc_html__( 'Price Typography', 'jet-grid-builder' ),
			'name'     => 'woocommerce_price_typography',
			'selector' => '{{WRAPPER}} .jgb_product-price',
		]
	);

	$this->add_control(
		'woocommerce_price_color',
		[
			'label'     => esc_html__( 'Price Color', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-price' => 'color: {{VALUE}};',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'label'    => esc_html__( 'Sale Typography', 'jet-grid-builder' ),
			'name'     => 'woocommerce_sale_typography',
			'selector' => '{{WRAPPER}} .jgb_product-price del',
		]
	);

	$this->add_control(
		'woocommerce_sale_color',
		[
			'label'     => esc_html__( 'Sale Color', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-price del' => 'color: {{VALUE}};',
			],
		]
	);

	$this->add_responsive_control(
		'woocommerce_price_align',
		[
			'label'   => esc_html__( 'Alignment', 'jet-grid-builder' ),
			'type'    => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'left' => [
					'title' => esc_html__( 'Left', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-center',
				],
				'right' => [
					'title' => esc_html__( 'Right', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-right',
				],
			],
			'selectors' => [
				'{{WRAPPER}} .jgb_product-price' => 'text-align: {{VALUE}};',
			],
		]
	);

	$this->add_control(
		'woocommerce_add_to_cart_controls',
		[
			'label'     => __( 'Woocommerce Add To Cart Options', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		]
	);

	$this->add_responsive_control(
		'woocommerce_add_to_cart_margin',
		[
			'label'      => esc_html__( 'Margin', 'jet-grid-builder' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_responsive_control(
		'woocommerce_add_to_cart_padding',
		[
			'label'      => esc_html__( 'Padding', 'jet-grid-builder' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Border::get_type(),
		[
			'name'     => 'woocommerce_add_to_cart_border',
			'selector' => '{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button',
		]
	);

	$this->add_control(
		'woocommerce_add_to_cart_border_radius',
		[
			'label'      => esc_html__( 'Border Radius', 'jet-grid-builder' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [
				'{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
			],
		]
	);

	$this->add_group_control(
		\Elementor\Group_Control_Typography::get_type(),
		[
			'name'     => 'woocommerce_add_to_cart_typography',
			'selector' => '{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button',
		]
	);

	$this->start_controls_tabs( 'woocommerce_add_to_cart_tabs' );

	$this->start_controls_tab(
		'woocommerce_add_to_cart_normal',
		[
			'label' => __( 'Normal', 'jet-grid-builder' ),
		]
	);

	$this->add_control(
		'woocommerce_add_to_cart_color',
		[
			'label'     => esc_html__( 'Text Color', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button' => 'color: {{VALUE}};',
			],
		]
	);

	$this->add_control(
		'woocommerce_add_to_cart_background',
		[
			'label'  => esc_html__( 'Background Color', 'jet-grid-builder' ),
			'type'   => \Elementor\Controls_Manager::COLOR,
			'scheme' => [
				'type'  => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}}  .jgb_product-add-to-cart .add_to_cart_button' => 'background-color: {{VALUE}};',
			],
		]
	);

	$this->end_controls_tab();

	$this->start_controls_tab(
		'woocommerce_add_to_cart_hover',
		[
			'label' => __( 'Hover', 'jet-grid-builder' ),
		]
	);

	$this->add_control(
		'woocommerce_add_to_cart_hover_color',
		[
			'label'  => esc_html__( 'Text Color', 'jet-grid-builder' ),
			'type'   => \Elementor\Controls_Manager::COLOR,
			'scheme' => [
				'type'  => \Elementor\Scheme_Color::get_type(),
				'value' => \Elementor\Scheme_Color::COLOR_1,
			],
			'selectors' => [
				'{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button:hover' => 'color: {{VALUE}};',
			],
		]
	);

	$this->add_control(
		'woocommerce_add_to_cart_hover_background',
		[
			'label'     => esc_html__( 'Background Color', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-add-to-cart .add_to_cart_button:hover' => 'background-color: {{VALUE}};',
			],
		]
	);

	$this->end_controls_tab();

	$this->end_controls_tabs();

	$this->add_responsive_control(
		'woocommerce_add_to_cart_align',
		[
			'label'   => esc_html__( 'Alignment', 'jet-grid-builder' ),
			'type'    => \Elementor\Controls_Manager::CHOOSE,
			'options' => [
				'flex-start' => [
					'title' => esc_html__( 'Left', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-left',
				],
				'center' => [
					'title' => esc_html__( 'Center', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-center',
				],
				'flex-end' => [
					'title' => esc_html__( 'Right', 'jet-grid-builder' ),
					'icon'  => 'fa fa-align-right',
				],
			],
			'selectors' => [
				'{{WRAPPER}} .jgb_product-add-to-cart' => 'justify-content: {{VALUE}};',
			],
		]
	);

	$this->end_controls_section();
}