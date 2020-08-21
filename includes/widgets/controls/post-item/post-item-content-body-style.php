<?php
/**
 * Post Item: content body style controls
 */

$this->start_controls_section(
	'post_content_body_style_section',
	[
		'label' => esc_html__( 'Post Item: Content Body', 'jet-grid-builder' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'items_type' => ['default', 'post_content']
		]
	]
);

$this->add_responsive_control(
	'content_body_margin',
	[
		'label'      => esc_html__( 'Margin', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-body' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'content_body_padding',
	[
		'label'      => esc_html__( 'Padding', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-body' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'content_body_border',
		'selector' => '{{WRAPPER}} .jgb_item-body',
	]
);

$this->add_control(
	'content_body_border_radius',
	[
		'label'      => esc_html__( 'Border Radius', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-body' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name'           => 'content_body_background',
		'label'          => esc_html__( 'Background', 'jet-grid-builder' ),
		'types'          => [ 'classic', 'gradient' ],
		'fields_options' => [
			'color' => [
				'scheme' => [
					'type'  => \Elementor\Scheme_Color::get_type(),
					'value' => \Elementor\Scheme_Color::COLOR_2,
				],
			],
		],
		'selector' => '{{WRAPPER}} .jgb_item-body',
	]
);

$this->end_controls_section();