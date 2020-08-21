<?php
/**
 * Term Style: posts count style controls
 */

$this->start_controls_section(
	'term_posts_count_style_section',
	[
		'label' => esc_html__( 'Term Item: Posts Count', 'jet-grid-builder' ),
		'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_responsive_control(
	'posts_count_margin',
	[
		'label'      => esc_html__( 'Margin', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_item-posts-count' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_control(
	'posts_count_color',
	[
		'label'     => esc_html__( 'Text Color', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .jgb_item-posts-count' => 'color: {{VALUE}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Typography::get_type(),
	[
		'name'     => 'posts_count_typography',
		'selector' => '{{WRAPPER}} .jgb_item-posts-count',
	]
);

$this->add_responsive_control(
	'posts_count_align',
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
			'{{WRAPPER}} .jgb_item-posts-count' => 'text-align: {{VALUE}};',
		],
	]
);

$this->end_controls_section();