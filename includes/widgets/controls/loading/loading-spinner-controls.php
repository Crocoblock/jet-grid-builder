<?php
/**
 * loading spinner controls
 */

$this->add_control(
	'loading_spinner',
	[
		'label'   => esc_html__( 'Loading Spinner', 'jet-grid-builder' ),
		'type'    => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
	]
);

$this->add_control(
	'loading_spinner_media',
	[
		'label'        => esc_html__( 'Show spinner until media loads', 'jet-grid-builder' ),
		'description'  => esc_html__( 'Only for default items type', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => '',
		'condition'    => [
			'loading_spinner' => 'true',
		],
		'render_type'  => 'none'
	]
);

$this->add_control(
	'loading_spinner_type',
	[
		'label'     => esc_html__( 'Spinner Type', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::SELECT,
		'options'   => [
			'circle-clip-growing' => esc_html__( 'Circle clip growing', 'jet-grid-builder' ),
			'circle-clip'         => esc_html__( 'Circle clip', 'jet-grid-builder' ),
			'circle'              => esc_html__( 'Circle', 'jet-grid-builder' ),
			'lines-wave'          => esc_html__( 'Lines wave', 'jet-grid-builder' ),
			'lines-pulse'         => esc_html__( 'Lines pulse', 'jet-grid-builder' ),
			'lines-pulse-rapid'   => esc_html__( 'Lines pulse rapid', 'jet-grid-builder' ),
			'cube-grid'           => esc_html__( 'Cube grid', 'jet-grid-builder' ),
			'cube-folding'        => esc_html__( 'Cube folding', 'jet-grid-builder' ),
			'wordpress'           => esc_html__( 'Wordpress', 'jet-grid-builder' ),
			'hash'                => esc_html__( 'Hash', 'jet-grid-builder' ),
			'dots-grid-pulse'     => esc_html__( 'Dots grid pulse', 'jet-grid-builder' ),
			'dots-grid-beat'      => esc_html__( 'Dots grid beat', 'jet-grid-builder' ),
			'dots-circle'         => esc_html__( 'Dots circle', 'jet-grid-builder' ),
			'dots-pulse'          => esc_html__( 'Dots pulse', 'jet-grid-builder' ),
			'dots-elastic'        => esc_html__( 'Dots elastic', 'jet-grid-builder' ),
			'dots-carousel'       => esc_html__( 'Dots carousel', 'jet-grid-builder' ),
			'dots-windmill'       => esc_html__( 'Dots windmill', 'jet-grid-builder' ),
			'dots-triangle-path'  => esc_html__( 'Dots triangle path', 'jet-grid-builder' ),
			'dots-bricks'         => esc_html__( 'Dots bricks', 'jet-grid-builder' ),
			'dots-fire'           => esc_html__( 'Dots fire', 'jet-grid-builder' ),
			'dots-rotate'         => esc_html__( 'Dots rotate', 'jet-grid-builder' ),
			'dots-bouncing'       => esc_html__( 'Dots bouncing', 'jet-grid-builder' ),
			'dots-chasing'        => esc_html__( 'Dots chasing', 'jet-grid-builder' ),
			'dots-propagate'      => esc_html__( 'Dots propagate', 'jet-grid-builder' ),
			'dots-spin-scale'     => esc_html__( 'Dots spin scale', 'jet-grid-builder' ),
		],
		'default'   => 'circle-clip-growing',
		'condition' => [
			'loading_spinner' => 'true',
		],
	]
);