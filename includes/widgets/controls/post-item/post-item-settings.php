<?php
/**
 * Post item settings controls
 */

use Posts_Grid_Builder\Plugin;

$this->start_controls_section(
	'post_settings_section',
	[
		'label' => esc_html__( 'Post Item', 'jet-grid-builder' ),
		'condition' => [
			'items_type' => ['default', 'post_content']
		]
	]
);

$this->add_control(
	'item_thumbnail',
	[
		'label'        => esc_html__( 'Thumbnail', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none'
	]
);

$this->add_control(
	'item_thumbnail_size',
	[
		'label'     => esc_html__( 'Thumbnail Size', 'jet-grid-builder' ),
		'type'      => \Elementor\Controls_Manager::SELECT,
		'options'   => Plugin::instance()->get_img_sizes(),
		'default'   => 'large',
		'condition' => [
			'item_thumbnail' => 'true',
		]
	]
);

$this->add_control(
	'item_title',
	[
		'label'        => esc_html__( 'Title', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_description',
	[
		'label'   => esc_html__( 'Description', 'jet-grid-builder' ),
		'type'    => \Elementor\Controls_Manager::SELECT,
		'options' => [
			'auto'    => esc_html__( 'Auto', 'jet-grid-builder' ),
			'content' => esc_html__( 'Content', 'jet-grid-builder' ),
			'excerpt' => esc_html__( 'Excerpt', 'jet-grid-builder' )
		],
		'default'     => 'auto',
		'render_type' => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_responsive_control(
	'item_description_words_count',
	[
		'label'       => esc_html__( 'Words count', 'jet-grid-builder' ),
		'type'        => \Elementor\Controls_Manager::NUMBER,
		'min'         => 0,
		'max'         => 100,
		'step'        => 1,
		'default'     => 15,
		'render_type' => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_post_author',
	[
		'label'        => esc_html__( 'Author', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_post_author_prefix',
	[
		'label'       => esc_html__( 'Author Prefix', 'jet-grid-builder' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => esc_html__( 'By', 'jet-grid-builder' ),
		'render_type' => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_post_date',
	[
		'label'        => esc_html__( 'Date', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_post_date_prefix',
	[
		'label'       => esc_html__( 'Date Prefix', 'jet-grid-builder' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => esc_html__( 'Posted', 'jet-grid-builder' ),
		'render_type' => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_post_date_format',
	[
		'label'   => esc_html__( 'Date Format', 'jet-grid-builder' ),
		'type'    => \Elementor\Controls_Manager::TEXT,
		'default' => 'F, j',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_divider',
	[
		'label'        => esc_html__( 'Divider', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->add_control(
	'item_post_type',
	[
		'label'        => esc_html__( 'Post Type', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none',
		'condition' => [
			'items_type' => 'default'
		]
	]
);

$this->end_controls_section();