<?php
/**
 *Post Item: divider style controls
 */

$this->start_controls_section(
	'post_divider_style_section',
	[
		'label' => esc_html__( 'Post Item: Divider', 'jet-grid-builder' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_responsive_control(
	'divider_margin',
	[
		'label'      => esc_html__( 'Margin', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-divider' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_control(
	'divider_style',
	[
		'label'   => esc_html__( 'Style', 'jet-grid-builder' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'options' => [
			'solid'  => esc_html__( 'Solid', 'jet-grid-builder' ),
			'double' => esc_html__( 'Double', 'jet-grid-builder' ),
			'dotted' => esc_html__( 'Dotted', 'jet-grid-builder' ),
			'dashed' => esc_html__( 'Dashed', 'jet-grid-builder' ),
		],
		'default'   => 'solid',
		'selectors' => [
			'{{WRAPPER}} .jgb_item-divider-separator' => 'border-top-style: {{VALUE}};',
		],
	]
);

$this->add_control(
	'divider_weight',
	[
		'label'   => esc_html__( 'Weight', 'jet-grid-builder' ),
		'type'    => \Elementor\Controls_Manager::SLIDER,
		'default' => [
			'size' => 1,
		],
		'range' => [
			'px' => [
				'min' => 1,
				'max' => 10,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_item-divider-separator' => 'border-top-width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_control(
	'divider_color',
	[
		'label' => esc_html__( 'Color', 'jet-grid-builder' ),
		'type'  => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-divider-separator' => 'border-top-color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
	'divider_width',
	[
		'label'      => esc_html__( 'Width', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::SLIDER,
		'size_units' => [ '%', 'px' ],
		'range' => [
			'px' => [
				'max' => 1000,
			],
		],
		'default' => [
			'size' => 100,
			'unit' => '%',
		],
		'tablet_default' => [
			'unit' => '%',
		],
		'mobile_default' => [
			'unit' => '%',
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_item-divider-separator' => 'width: {{SIZE}}{{UNIT}};',
		],
	]
);

$this->add_responsive_control(
	'divider_align',
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
			'{{WRAPPER}} .jgb_item-divider' => 'text-align: {{VALUE}};',
		],
	]
);

$this->end_controls_section();