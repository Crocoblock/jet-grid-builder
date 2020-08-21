<?php
/**
 * Term Item: title style controls
 */

$this->start_controls_section(
	'term_title_style_section',
	[
		'label' => esc_html__( 'Term Item: Title', 'jet-grid-builder' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_responsive_control(
	'title_margin',
	[
		'label'      => esc_html__( 'Margin', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_control(
	'title_color',
	[
		'label'     => esc_html__( 'Text Color', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-title' => 'color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	[
		'name'     => 'title_typography',
		'selector' => '{{WRAPPER}} .jgb_item-title',
	]
);

$this->add_responsive_control(
	'title_align',
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
			'{{WRAPPER}} .jgb_item-title' => 'text-align: {{VALUE}};',
		],
	]
);

$this->end_controls_section();