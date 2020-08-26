<?php
/**
 * loading spinner controls
 */

$this->add_control(
	'loading_spinner',
	[
		'label'   => esc_html__( 'Loading Spinner', 'jet-grid-builder-preview' ),
		'type'    => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder-preview' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder-preview' ),
		'return_value' => 'true',
		'default'      => 'true',
	]
);

$this->add_control(
	'loading_spinner_media',
	[
		'label'   => esc_html__( 'Show spinner until media loads', 'jet-grid-builder-preview' ),
		'type'    => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder-preview' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder-preview' ),
		'return_value' => 'true',
		'default'      => '',
		'condition' => [
			'loading_spinner' => 'true',
			'items_type'      => 'default'
		],
		'render_type'  => 'none'
	]
);

$this->add_control(
	'loading_spinner_type',
	[
		'label'     => esc_html__( 'Spinner Type', 'jet-grid-builder-preview' ),
		'type'      => \Elementor\Controls_Manager::SELECT,
		'options'   => [
			'circle-clip-growing' => esc_html__( 'Circle clip growing', 'jet-grid-builder-preview' ),
			'circle-clip'         => esc_html__( 'Circle clip', 'jet-grid-builder-preview' ),
			'circle'              => esc_html__( 'Circle', 'jet-grid-builder-preview' ),
			'lines-wave'          => esc_html__( 'Lines wave', 'jet-grid-builder-preview' ),
			'lines-pulse'         => esc_html__( 'Lines pulse', 'jet-grid-builder-preview' ),
			'lines-pulse-rapid'   => esc_html__( 'Lines pulse rapid', 'jet-grid-builder-preview' ),
			'cube-grid'           => esc_html__( 'Cube grid', 'jet-grid-builder-preview' ),
			'cube-folding'        => esc_html__( 'Cube folding', 'jet-grid-builder-preview' ),
			'wordpress'           => esc_html__( 'Wordpress', 'jet-grid-builder-preview' ),
			'hash'                => esc_html__( 'Hash', 'jet-grid-builder-preview' ),
			'dots-grid-pulse'     => esc_html__( 'Dots grid pulse', 'jet-grid-builder-preview' ),
			'dots-grid-beat'      => esc_html__( 'Dots grid beat', 'jet-grid-builder-preview' ),
			'dots-circle'         => esc_html__( 'Dots circle', 'jet-grid-builder-preview' ),
			'dots-pulse'          => esc_html__( 'Dots pulse', 'jet-grid-builder-preview' ),
			'dots-elastic'        => esc_html__( 'Dots elastic', 'jet-grid-builder-preview' ),
			'dots-carousel'       => esc_html__( 'Dots carousel', 'jet-grid-builder-preview' ),
			'dots-windmill'       => esc_html__( 'Dots windmill', 'jet-grid-builder-preview' ),
			'dots-triangle-path'  => esc_html__( 'Dots triangle path', 'jet-grid-builder-preview' ),
			'dots-bricks'         => esc_html__( 'Dots bricks', 'jet-grid-builder-preview' ),
			'dots-fire'           => esc_html__( 'Dots fire', 'jet-grid-builder-preview' ),
			'dots-rotate'         => esc_html__( 'Dots rotate', 'jet-grid-builder-preview' ),
			'dots-bouncing'       => esc_html__( 'Dots bouncing', 'jet-grid-builder-preview' ),
			'dots-chasing'        => esc_html__( 'Dots chasing', 'jet-grid-builder-preview' ),
			'dots-propagate'      => esc_html__( 'Dots propagate', 'jet-grid-builder-preview' ),
			'dots-spin-scale'     => esc_html__( 'Dots spin scale', 'jet-grid-builder-preview' ),
		],
		'default'   => 'circle-clip-growing',
		'condition' => [
			'loading_spinner' => 'true',
		],
	]
);