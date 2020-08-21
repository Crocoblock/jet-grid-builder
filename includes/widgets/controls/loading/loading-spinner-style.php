<?php
/**
 * loading spinner style controls
 */

$this->start_controls_section(
	'loading_spinner_section',
	[
		'label'      => esc_html__( 'Loading Spinner', 'jet-grid-builder' ),
		'tab'        => \Elementor\Controls_Manager::TAB_STYLE,
		'show_label' => false,
		'condition'  => [
			'loading_spinner' => 'true',
		],
	]
);

$this->add_control(
	'loading_spinner_color',
	[
		'label'  => esc_html__( 'Spinner Color', 'jet-grid-builder' ),
		'type'   => \Elementor\Controls_Manager::COLOR,
		'scheme' => [
			'type'  => \Elementor\Scheme_Color::get_type(),
			'value' => \Elementor\Scheme_Color::COLOR_1,
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_spinner' => 'color: {{VALUE}};',
		],
	]
);

$this->add_control(
	'loading_spinner_size',
	[
		'label' => esc_html__( 'Spinner Size', 'jet-grid-builder' ),
		'type'  => \Elementor\Controls_Manager::SLIDER,
		'range' => [
			'px' => [
				'max' => 200,
				'min' => 20,
				'step' => 1,
			],
		],
		'selectors' => [
			'{{WRAPPER}} .jgb_spinner' => 'font-size: {{SIZE}}{{UNIT}};',
		]
	]
);

$this->add_control(
	'loading_spinner_background',
	[
		'label'     => esc_html__( 'Spinner background', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::COLOR,
		'selectors' => [
			'{{WRAPPER}} .jgb_spinner' => 'background-color: {{VALUE}};',
		],
	]
);

$this->add_responsive_control(
	'loading_spinner_padding',
	[
		'label'      => esc_html__( 'Padding', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_spinner' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Border::get_type(),
	[
		'name'     => 'loading_spinner_border',
		'selector' => '{{WRAPPER}} .jgb_spinner',
	]
);

$this->add_control(
	'loading_spinner_border_radius',
	[
		'label'      => esc_html__( 'Border Radius', 'jet-grid-builder' ),
		'type'       => \Elementor\Controls_Manager::DIMENSIONS,
		'size_units' => [ 'px', '%' ],
		'selectors'  => [
			'{{WRAPPER}} .jgb_spinner' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
		],
	]
);

$this->add_group_control(
	\Elementor\Group_Control_Box_Shadow::get_type(),
	[
		'name'     => 'loading_spinner_shadow',
		'label'    => esc_html__( 'Box Shadow', 'jet-grid-builder' ),
		'selector' => '{{WRAPPER}} .jgb_spinner'
	]
);

$this->end_controls_section();