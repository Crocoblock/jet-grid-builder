<?php
namespace Posts_Grid_Builder;

use Jet_Engine_CX_Loader;

/**
 * Main file
 */
class Plugin {

	/**
	 * Instance.
	 *
	 * Holds the plugin instance.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @var Plugin
	 */
	public static $instance = null;

	/**
	 * Plugin components
	 */
	public $api;
	public $assets;
	public $elementor;

	/**
	 * Plugin constructor.
	 */
	private function __construct() {

		// Initialize plugin components
		add_action( 'after_setup_theme', array( $this, 'init_components' ), 0 );
		// Internationalize the text strings used.
		add_action( 'init', array( $this, 'lang' ), -999 );

	}

	/**
	 * Instance.
	 *
	 * Ensures only one instance of the plugin class is loaded or can be loaded.
	 *
	 * @since 1.0.0
	 * @access public
	 * @static
	 *
	 * @return Plugin An instance of the class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {

			self::$instance = new self();

			/**
			 * Plugin loaded
			 *
			 * @since 1.0.0
			 */
			do_action( 'posts-grid-builder/loaded' );

		}

		return self::$instance;

	}

	/**
	 * Initialize plugin parts
	 *
	 * @return void
	 */
	public function init_components() {

		spl_autoload_register( array( $this, 'autoloader' ) );

		do_action( 'posts-grid-builder/before-init' );

		$this->api       = new Api();
		$this->assets    = new Assets();
		$this->elementor = new Elementor_Manager();

		do_action( 'posts-grid-builder/init' );

	}

	/**
	 * Loads the translation files.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function lang() {

		load_plugin_textdomain( 'jet-grid-builder', false, JET_GRID_BUILDER_PATH . 'languages' );

	}

	/**
	 * Assets file
	 *
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	public function assets_url( $file = '' ) {

		return JET_GRID_BUILDER_URL . 'assets/' . $file;

	}

	/**
	 * Return template path
	 *
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	public function plugin_path( $file = '' ) {

		return JET_GRID_BUILDER_PATH . $file;

	}

	/**
	 * Get the template path.
	 *
	 * @return string
	 */
	public function template_path() {

		return apply_filters( 'posts-grid-builder/template-path', 'posts-grid-builder/' );

	}

	/**
	 * Check if theme has elementor
	 *
	 * @return boolean
	 */
	public function has_elementor() {

		return defined( 'ELEMENTOR_VERSION' );

	}

	/**
	 * Returns path to widgets common controls.
	 *
	 * @return string|bool
	 */
	public function get_controls( $name = null ) {

		$controls = $this->plugin_path( 'includes/widgets/controls/' . $name );

		if ( file_exists( $controls ) ) {
			return $controls;
		} else {
			return false;
		}

	}

	/**
	 * Returns path to template file.
	 *
	 * @return string|bool
	 */
	public function get_template( $name = null ) {

		$template = locate_template( $this->template_path() . $name );

		if ( ! $template ) {
			$template = $this->plugin_path( 'templates/' . $name );
		}

		if ( file_exists( $template ) ) {
			return $template;
		} else {
			return false;
		}

	}

	/**
	 * Get post types options list
	 *
	 * @return array
	 */
	public function get_post_types() {

		$post_types = get_post_types( array( 'public' => true ), 'objects' );

		$exclude = apply_filters( 'posts-grid-builder/post-types/exclude', array(
			'attachment',
			'elementor_library'
		) );

		$result = array();

		if ( empty( $post_types ) ) {
			return $result;
		}

		foreach ( $post_types as $slug => $post_type ) {
			if ( in_array( $slug, $exclude ) ) {
				continue;
			}
			$result[ $slug ] = $post_type->label;
		}

		return $result;

	}

	/**
	 * Get all terms options list
	 *
	 * @return array
	 */
	public function get_all_terms() {

		$terms = get_terms();

		$exclude = apply_filters( 'posts-grid-builder/all-terms/exclude', array(
			'main-menu'
		) );

		$result = array();

		if ( empty( $terms ) ) {
			return $result;
		}
		
		foreach ( $terms as $term ) {
			if ( in_array( $term->slug, $exclude ) ) {
				continue;
			}
			$result[ $term->slug ] = $term->name;
		}

		$result = array( 'all' => esc_html__( 'All', 'jet-grid-builder' ) ) + $result;

		return $result;

	}

	/**
	 * Return registered image sizes list
	 *
	 * @return [type] [description]
	 */
	public function get_img_sizes() {

		global $_wp_additional_image_sizes;

		$sizes  = get_intermediate_image_sizes();
		$result = array();

		foreach ( $sizes as $size ) {
			if ( in_array( $size, array( 'thumbnail', 'medium', 'medium_large', 'large' ) ) ) {
				$result[ $size ] = ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) );
			} else {
				$result[ $size ] = sprintf(
					'%1$s (%2$sx%3$s)',
					ucwords( trim( str_replace( array( '-', '_' ), array( ' ', ' ' ), $size ) ) ),
					$_wp_additional_image_sizes[ $size ]['width'],
					$_wp_additional_image_sizes[ $size ]['height']
				);
			}
		}

		return array_merge( array( 'full' => esc_html__( 'Full', 'jet-grid-builder' ), ), $result );

	}

	/**
	 * Return Thumbnail Data
	 */
	public function get_thumbnail_data( $thumb_id, $thumbnail_size = false ) {

		if ( ! $thumb_id )
			return array();

		$img_meta = wp_get_attachment_metadata( $thumb_id );
		if ( empty( $img_meta['sizes'] ) )
			return array();

		$result = array();
		$upload_dir = trailingslashit( UPLOAD_BASE_URL );
		$upload_folder = dirname($img_meta['file']);
		$upload_folder = $upload_folder !== '.' ? trailingslashit( $upload_folder ) : '';

		$result[ 'full' ] = array(
			'file'   => $upload_dir . $img_meta['file'],
			'width'  => $img_meta['width'],
			'height' => $img_meta['height']
		);

		foreach ( $img_meta['sizes'] as $size => $data ) {
			$result[ $size ] = array(
				'file'   => $upload_dir . $upload_folder . $data['file'],
				'width'  => $data['width'],
				'height' => $data['height']
			);
		}

		if ( $thumbnail_size ) 
			return isset( $result[$thumbnail_size] ) ? $result[$thumbnail_size] : $result['full'];

		return $result;

	}

	public function get_items_type_options() {

		$items_type_options = [
			'default'      => esc_html__( 'Default', 'jet-grid-builder' ),
			'post_content' => esc_html__( 'Post Content', 'jet-grid-builder' ),
		];

		if ( class_exists( 'Jet_Engine' ) ) {
			$items_type_options['jetengine_listing'] = esc_html__( 'JetEngine Listing', 'jet-grid-builder' );
		}

		return $items_type_options;

	}

	public function get_woo_items_type_options() {

		$woo_items_type_options = [
			'default'      => esc_html__( 'Default', 'jet-grid-builder' )
		];

		if ( class_exists( 'Jet_Woo_Builder' ) ) {
			$woo_items_type_options['jet_woo_builder_archive'] = esc_html__( 'JetWooBuilder Archive', 'jet-grid-builder' );
		}

		return $woo_items_type_options;

	}

	public function get_jet_engine_listings_options() {

		$listings = jet_engine()->listings->get_listings();
		$list = wp_list_pluck( $listings, 'post_title', 'ID' );

		return $list;

	}

	public function get_jet_woo_builder_archive_options() {

		$listings = jet_woo_builder_post_type()->get_templates_list( 'archive' );
		$list = wp_list_pluck( $listings, 'post_title', 'ID' );

		return $list;

	}

	public function include_item_template_by_type( $type = 'default', $style = 'default' ) {

		switch ( $type ) {
			case 'post_content':
				// post content item template
				include $this->get_template( 'items/post-content-item.php' );

				break;

			case 'jetengine_listing':
				// jetengine listing item template
				include $this->get_template( 'items/jetengine-listing-item.php' );

				break;

			case 'jet_woo_builder_archive':
				// jetengine listing item template
				include $this->get_template( 'items/jet_woo_builder-item.php' );

				break;
			
			default:
				// default item template
				include $this->get_template( 'items/item-' . $style . '.php' );

				break;

		}

	}

	public function include_woo_item_template_by_type( $woo_type = 'default', $woo_style = 'default' ) {

		if ( ! class_exists( 'WooCommerce' ) ) {
			return;
		}

		switch ( $woo_type ) {
			case 'jet_woo_builder_archive':
				// jet woo builder item template
				include $this->get_template( 'items/woocommerce-item-jet-woo-builder.php' );

				break;

			default:
				// default woo item template
				include $this->get_template( 'items/woocommerce-item-' . $woo_style . '.php' );

				break;
		}

	}

	/**
	 * Print inline CSS for a post built with elementor
	 */
	public function print_elementor_post_inline_css( $post_id ) {

		$css_file = \Elementor\Core\Files\CSS\Post::create( $post_id );
		$css      = $css_file->get_content();

		if ( ! empty( $css ) ) {
			$css_file->print_css();
		}

	}

	/**
	 * Register autoloader.
	 */
	private function autoloader( $class ) {

		if ( false === strpos( $class, 'Posts_Grid_Builder' ) ) {
			return;
		}

		$class = str_replace( '\\', DIRECTORY_SEPARATOR, $class );
		$class = str_replace( 'Posts_Grid_Builder', 'includes', $class );
		$class = str_replace( '_', '-', $class );
		$class = strtolower( $class );

		$file = JET_GRID_BUILDER_PATH . DIRECTORY_SEPARATOR . $class . '.php';

		if ( file_exists( $file ) ) {
			require $file;
		}

	}

}

Plugin::instance();
