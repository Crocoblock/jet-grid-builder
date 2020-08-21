<?php
/**
 * Woocommerce product settings controls
 */

if ( class_exists( 'WooCommerce' ) ) {
	$this->start_controls_section(
		'woocommerce_settings_section',
		[
			'label' => esc_html__( 'Woocommerce Product', 'jet-grid-builder' ),
			'condition' => [
				'woo_items_type' => 'default'
			]
		]
	);

	$this->add_control(
		'woocommerce_item_stars_rating',
		[
			'label'        => esc_html__( 'Stars Rating', 'jet-grid-builder' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
			'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
			'return_value' => 'true',
			'default'      => 'true',
			'render_type'  => 'none'
		]
	);

	$this->add_control(
		'woocommerce_item_categories',
		[
			'label'        => esc_html__( 'Categories', 'jet-grid-builder' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
			'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
			'return_value' => 'true',
			'default'      => 'true',
			'render_type'  => 'none'
		]
	);

	$this->add_control(
		'woocommerce_item_price',
		[
			'label'        => esc_html__( 'Price', 'jet-grid-builder' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
			'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
			'return_value' => 'true',
			'default'      => 'true',
			'render_type'  => 'none'
		]
	);

	$this->add_control(
		'woocommerce_item_add_to_cart',
		[
			'label'        => esc_html__( 'Add To Cart', 'jet-grid-builder' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
			'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
			'return_value' => 'true',
			'default'      => 'true',
			'render_type'  => 'none'
		]
	);

	$this->add_control(
		'woocommerce_item_add_to_cart_text',
		[
			'label'       => esc_html__( 'Add To Cart Text', 'jet-grid-builder' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => esc_html__( 'Add to cart', 'jet-grid-builder' ),
			'render_type' => 'none',
			'condition'   => [
				'woocommerce_item_add_to_cart' => 'true'
			]
		]
	);

	$this->end_controls_section();
}