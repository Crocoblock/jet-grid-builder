<?php
/**
 * Term item style controls
 */

$this->start_controls_section(
	'term_style_section',
	[
		'label' => esc_html__( 'Term Item', 'jet-grid-builder' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
	]
);

$this->add_control(
	'term_content_vertical_align',
	array(
		'label'   => __( 'Content Align', 'jet-grid-builder' ),
		'type'    => \Elementor\Controls_Manager::CHOOSE,
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
			'{{WRAPPER}} .jgb_item-jet-listing' => 'justify-content: {{VALUE}};',
		],
		'condition' => [
			'items_type' => 'jetengine_listing'
		]
	)
);

$this->add_responsive_control(
	'term_padding',
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
		'name'     => 'term_border',
		'selector' => '{{WRAPPER}} .jgb_item-container',
	]
);

$this->add_control(
	'term_border_radius',
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
		'name'     => 'term_background',
		'label'    => esc_html__( 'Background', 'jet-grid-builder' ),
		'types'    => [ 'classic', 'gradient' ],
		'selector' => '{{WRAPPER}} .jgb_item-container',
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'term_shadow',
		'label'    => esc_html__( 'Box Shadow', 'jet-grid-builder' ),
		'selector' => '{{WRAPPER}} .jgb_item-container'
	]
);

$this->add_control(
	'term_image_opacity',
	[
		'label' => esc_html__( 'Image Opacity', 'jet-grid-builder' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => [
			'px' => [
				'max'  => 1,
				'min'  => 0.10,
				'step' => 0.01,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_item-thumb' => 'opacity: {{SIZE}};',
		]
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Css_Filter::get_type(),
	[
		'label'    => esc_html__( 'Image CSS Filters', 'jet-grid-builder' ),
		'name'     => 'term_image_css_filters',
		'selector' => '{{WRAPPER}} .jgb_item-thumb'
	]
);

$this->end_controls_section();