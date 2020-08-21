<?php
/**
 * Term item settings controls
 */

use Posts_Grid_Builder\Plugin;

$this->start_controls_section(
	'term_settings_section',
	[
		'label'     => esc_html__( 'Term Item', 'jet-grid-builder' ),
		'condition' => [
			'items_type' => 'default'
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
		'condition' => ['item_thumbnail' => 'true']
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
		'render_type'  => 'none'
	]
);

$this->add_control(
	'item_description',
	[
		'label'        => esc_html__( 'Description', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none'
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
		'condition'   => [
			'item_description' => 'true'
		]
	]
);

$this->add_control(
	'item_post_count',
	[
		'label'        => esc_html__( 'Posts Count', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none'
	]
);

$this->add_control(
	'item_posts_count_prefix',
	[
		'label'       => esc_html__( 'Posts Count Prefix', 'jet-grid-builder' ),
		'type'        => \Elementor\Controls_Manager::TEXT,
		'default'     => esc_html__( 'Posts Count:', 'jet-grid-builder' ),
		'render_type' => 'none',
		'condition'   => [
			'item_post_count' => 'true'
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
		'render_type'  => 'none'
	]
);

$this->add_control(
	'item_term_taxonomy',
	[
		'label'        => esc_html__( 'Term Taxonomy', 'jet-grid-builder' ),
		'type'         => \Elementor\Controls_Manager::SWITCHER,
		'label_on'     => esc_html__( 'Yes', 'jet-grid-builder' ),
		'label_off'    => esc_html__( 'No', 'jet-grid-builder' ),
		'return_value' => 'true',
		'default'      => 'true',
		'render_type'  => 'none'
	]
);

$this->end_controls_section();