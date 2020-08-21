<?php
/**
 * Term order style
 */

$this->start_controls_section(
	'order_style_section',
	[
		'label'      => esc_html__( 'Term Item Elemements Order', 'jet-grid-builder' ),
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
	'posts_count_order',
	[
		'label'     => esc_html__( 'Posts Count Order', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::NUMBER,
		'default'   => 1,
		'min'       => 0,
		'max'       => 10,
		'step'      => 1,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-posts-count' => 'order: {{VALUE}};',
		]
	]
);

$this->end_controls_section();