<?php
/**
 * Post item order style controls
 */

$this->start_controls_section(
	'order_style_section',
	[
		'label'      => esc_html__( 'Post Item Elements Order', 'jet-grid-builder' ),
		'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
		'show_label' => false,
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'title_order',
	[
		'label'     => esc_html__( 'Title Order', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'default'   => 1,
		'min'       => 0,
		'max'       => 10,
		'step'      => 1,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-title' => 'order: {{VALUE}};',
		]
	]
);

$this->add_control(
	'description_order',
	[
		'label'     => esc_html__( 'Description Order', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'default'   => 1,
		'min'       => 0,
		'max'       => 10,
		'step'      => 1,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-description' => 'order: {{VALUE}};',
		]
	]
);

$this->add_control(
	'divider_order',
	[
		'label'     => esc_html__( 'Divider Order', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'default'   => 1,
		'min'       => 0,
		'max'       => 10,
		'step'      => 1,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-divider' => 'order: {{VALUE}};',
		]
	]
);

$this->add_control(
	'meta_order',
	[
		'label'     => esc_html__( 'Meta Order', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'default'   => 1,
		'min'       => 0,
		'max'       => 10,
		'step'      => 1,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-meta' => 'order: {{VALUE}};',
		]
	]
);

$this->add_control(
	'type_label_order',
	[
		'label'     => esc_html__( 'Type Label Order (is no thumbnail)', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'default'   => 1,
		'min'       => 0,
		'max'       => 10,
		'step'      => 1,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-type-wrap' => 'order: {{VALUE}};',
		]
	]
);

if ( class_exists( 'WooCommerce' ) ) {
	$this->add_control(
		'woocommerce_rating_order',
		[
			'label'     => esc_html__( 'Woocommerce Rating Order', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 1,
			'min'       => 0,
			'max'       => 10,
			'step'      => 1,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-stars-rating' => 'order: {{VALUE}};',
			]
		]
	);

	$this->add_control(
		'woocommerce_categories_order',
		[
			'label'     => esc_html__( 'Woocommerce Categories Order', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 1,
			'min'       => 0,
			'max'       => 10,
			'step'      => 1,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-categories' => 'order: {{VALUE}};',
			]
		]
	);

	$this->add_control(
		'woocommerce_price_order',
		[
			'label'     => esc_html__( 'Woocommerce Price Order', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 1,
			'min'       => 0,
			'max'       => 10,
			'step'      => 1,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-price' => 'order: {{VALUE}};',
			]
		]
	);

	$this->add_control(
		'woocommerce_add_to_cart_order',
		[
			'label'     => esc_html__( 'Woocommerce Add To Cart Order', 'jet-grid-builder' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 1,
			'min'       => 0,
			'max'       => 10,
			'step'      => 1,
			'selectors' => [
				'{{WRAPPER}} .jgb_product-add-to-cart' => 'order: {{VALUE}};',
			]
		]
	);
}

$this->end_controls_section();