<?php
/**
 * Post item style controls
 */

$this->start_controls_section(
	'post_style_section',
	[
		'label' => esc_html__( 'Post Item', 'jet-grid-builder' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	]
);

$this->add_control(
	'post_content_vertical_align',
	array(
		'label'   => __( 'Content Align', 'jet-grid-builder' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
		'toggle'  => false,
		'default' => 'flex-start',
		'options'     => array(
			'flex-start' => array(
				'title' => esc_html__( 'Top', 'jet-grid-builder' ),
				'icon'  => 'eicon-v-align-top',
			),
			'center' => array(
				'title' => esc_html__( 'Middle', 'jet-grid-builder' ),
				'icon'  => 'eicon-v-align-middle',
			),
			'flex-end' => array(
				'title' => esc_html__( 'Bottom', 'jet-grid-builder' ),
				'icon'  => 'eicon-v-align-bottom',
			),
		),
		'selectors' => [
			'{{WRAPPER}} .jgb_item-post-content, {{WRAPPER}} .jgb_item-jet-listing' => 'justify-content: {{VALUE}};',
		],
		'condition' => [
			'items_type' => ['post_content', 'jetengine_listing', 'jet_woo_builder_archive']
		]
	)
);

$this->add_responsive_control(
	'post_padding',
	[
		'label'      => esc_html__( 'Padding', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'post_border',
		'selector' => '{{WRAPPER}} .jgb_item-container',
	]
);

$this->add_control(
	'post_border_radius',
	[
		'label'      => esc_html__( 'Border Radius', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-container' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Background::get_type(),
	[
		'name'     => 'post_background',
		'label'    => esc_html__( 'Background', 'jet-grid-builder' ),
		'types'    => [ 'classic', 'gradient' ],
		'selector' => '{{WRAPPER}} .jgb_item-container',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'post_shadow',
		'label'    => esc_html__( 'Box Shadow', 'jet-grid-builder' ),
		'selector' => '{{WRAPPER}} .jgb_item-container'
	]
);

$this->add_control(
	'post_image_opacity',
	[
		'label' => esc_html__( 'Image Opacity', 'jet-grid-builder' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => [
			'px' => [
				'max' => 1,
				'min' => 0.10,
				'step' => 0.01,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_item-thumb' => 'opacity: {{SIZE}};',
		],
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Css_Filter::get_type(),
	[
		'label'    => esc_html__( 'Image CSS Filters', 'jet-grid-builder' ),
		'name'     => 'post_image_css_filters',
		'selector' => '{{WRAPPER}} .jgb_item-thumb',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->end_controls_section();