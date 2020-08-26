<?php
/**
 * Post Item: type label style controls
 */

$this->start_controls_section(
	'post_type_label_style_section',
	[
		'label' => esc_html__( 'Post Item: Type Label', 'jet-grid-builder-preview' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_responsive_control(
	'post_type_margin',
	[
		'label'      => esc_html__( 'Margin', 'jet-grid-builder-preview' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-type-wrap' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} 0 {{LEFT}}{{UNIT}};',
			'{{WRAPPER}} .jgb_item-type'      => 'margin-bottom: {{BOTTOM}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'post_type_padding',
	[
		'label'      => esc_html__( 'Padding', 'jet-grid-builder-preview' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-type' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'post_type_border',
		'selector' => '{{WRAPPER}} .jgb_item-type',
	]
);

$this->add_control(
	'post_type_border_radius',
	[
		'label'      => esc_html__( 'Border Radius', 'jet-grid-builder-preview' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-type' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_control(
	'post_type_background',
	[
		'label'  => esc_html__( 'Background Color', 'jet-grid-builder-preview' ),
		'type'   => \Elementor\Controls_Manager::COLOR,
		'scheme' => [
			'type'  => \Elementor\Scheme_Color::get_type(),
			'value' => \Elementor\Scheme_Color::COLOR_1,
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_item-type' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'post_type_shadow',
		'label'    => esc_html__( 'Box Shadow', 'jet-grid-builder-preview' ),
		'selector' => '{{WRAPPER}} .jgb_item-type'
	]
);

$this->add_control(
	'post_type_color',
	[
		'label'     => esc_html__( 'Text Color', 'jet-grid-builder-preview' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-type' => 'color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	[
		'name'     => 'post_type_typography',
		'selector' => '{{WRAPPER}} .jgb_item-type',
	]
);

$this->add_responsive_control(
	'post_type_align',
	[
		'label'   => esc_html__( 'Alignment', 'jet-grid-builder-preview' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'options' => [
			'left' => [
				'title' => esc_html__( 'Left', 'jet-grid-builder-preview' ),
				'icon'  => 'fa fa-align-left',
			],
			'center' => [
				'title' => esc_html__( 'Center', 'jet-grid-builder-preview' ),
				'icon'  => 'fa fa-align-center',
			],
			'right' => [
				'title' => esc_html__( 'Right', 'jet-grid-builder-preview' ),
				'icon'  => 'fa fa-align-right',
			],
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_item-type-wrap' => 'text-align: {{VALUE}};',
		],
	]
);

$this->end_controls_section();