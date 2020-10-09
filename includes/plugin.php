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
		$this->gutenberg = new Gutenberg_Manager();

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

	public function get_grid_builder_settings( $settings ) {

		$result   = array();

		// grid settings
		$result['posts']                               = isset( $settings['posts'] ) ? $settings['posts'] : '';
		$result['layout_data']                         = isset( $settings['layout_data'] ) ? $settings['layout_data'] : '';
		$result['layout_data_tablet']                  = isset( $settings['layout_data_tablet'] ) ? $settings['layout_data_tablet'] : '';
		$result['layout_data_mobile']                  = isset( $settings['layout_data_mobile'] ) ? $settings['layout_data_mobile'] : '';
		$result['colNum']                              = isset( $settings['colNum'] ) ? $settings['colNum'] : 24;
		$result['gutter']                              = isset( $settings['gutter'] ) ? $settings['gutter'] : 10;
		$result['gutter_tablet']                       = isset( $settings['gutter_tablet'] ) ? $settings['gutter_tablet'] : '';
		$result['gutter_mobile']                       = isset( $settings['gutter_mobile'] ) ? $settings['gutter_mobile'] : '';
		$result['vertical_compact']                    = isset( $settings['vertical_compact'] ) ? $settings['vertical_compact'] : false;
		$result['items_type']                          = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$result['woo_items_type']                      = isset( $settings['woo_items_type'] ) ? $settings['woo_items_type'] : 'default';
		$result['jetengine_listing_id']                = isset( $settings['jetengine_listing_id'] ) && 'jetengine_listing' === $settings['items_type'] ? esc_attr( $settings['jetengine_listing_id'] ) : false;
		$result['jet_woo_builder_archive_id']          = isset( $settings['jet_woo_builder_archive_id'] ) && 'jet_woo_builder_archive' === $settings['woo_items_type'] ? esc_attr( $settings['jet_woo_builder_archive_id'] ) : false;
		$result['loading_spinner']                     = isset( $settings['loading_spinner'] ) ? $settings['loading_spinner'] : true;
		$result['loading_spinner_media']               = isset( $settings['loading_spinner_media'] ) ? $settings['loading_spinner_media'] : '';

		// item settings
		$result['item_style']                          = isset( $settings['item_style'] ) ? $settings['item_style'] : 'default';
		$result['item_thumbnail']                      = isset( $settings['item_thumbnail'] ) ? $settings['item_thumbnail'] : true;
		$result['item_thumbnail_size']                 = isset( $settings['item_thumbnail_size'] ) ? $settings['item_thumbnail_size'] : 'large';
		$result['item_post_type']                      = isset( $settings['item_post_type'] ) ? $settings['item_post_type'] : true;
		$result['item_title']                          = isset( $settings['item_title'] ) ? $settings['item_title'] : true;
		$result['item_description']                    = isset( $settings['item_description'] ) ? $settings['item_description'] : true;
		$result['item_description_words_count']        = isset( $settings['item_description_words_count'] ) ? $settings['item_description_words_count'] : 15;
		$result['item_description_words_count_tablet'] = isset( $settings['item_description_words_count_tablet'] ) ? $settings['item_description_words_count_tablet'] : 15;
		$result['item_description_words_count_mobile'] = isset( $settings['item_description_words_count_mobile'] ) ? $settings['item_description_words_count_mobile'] : 15;
		$result['item_post_author']                    = isset( $settings['item_post_author'] ) ? $settings['item_post_author'] : true;
		$result['item_post_author_prefix']             = isset( $settings['item_post_author_prefix'] ) ? $settings['item_post_author_prefix'] : '';
		$result['item_post_date']                      = isset( $settings['item_post_date'] ) ? $settings['item_post_date'] : true;
		$result['item_post_date_prefix']               = isset( $settings['item_post_date_prefix'] ) ? $settings['item_post_date_prefix'] : '';
		$result['item_post_date_format']               = isset( $settings['item_post_date_format'] ) ? $settings['item_post_date_format'] : 'F, j';
		$result['item_divider']                        = isset( $settings['item_divider'] ) ? $settings['item_divider'] : true;

		// Woocommerce product settings
		$result['woocommerce_item_stars_rating']       = isset( $settings['woocommerce_item_stars_rating'] ) ? $settings['woocommerce_item_stars_rating'] : true;
		$result['woocommerce_item_categories']         = isset( $settings['woocommerce_item_categories'] ) ? $settings['woocommerce_item_categories'] : true;
		$result['woocommerce_item_price']              = isset( $settings['woocommerce_item_price'] ) ? $settings['woocommerce_item_price'] : true;
		$result['woocommerce_item_add_to_cart']        = isset( $settings['woocommerce_item_add_to_cart'] ) ? $settings['woocommerce_item_add_to_cart'] : true;
		$result['woocommerce_item_add_to_cart_text']   = isset( $settings['woocommerce_item_add_to_cart_text'] ) ? esc_attr( $settings['woocommerce_item_add_to_cart_text'] ) : 'Add to cart';

		$result = apply_filters( 'posts-grid-builder/data-settings', $result );

		return json_encode( $result );

	}

	public function get_grid_builder_terms_settings( $settings ) {

		$result   = array();

		// grid settings
		$result['terms']                               = isset( $settings['terms'] ) ? $settings['terms'] : '';
		$result['layout_data']                         = isset( $settings['layout_data'] ) ? $settings['layout_data'] : '';
		$result['layout_data_tablet']                  = isset( $settings['layout_data_tablet'] ) ? $settings['layout_data_tablet'] : '';
		$result['layout_data_mobile']                  = isset( $settings['layout_data_mobile'] ) ? $settings['layout_data_mobile'] : '';
		$result['colNum']                              = isset( $settings['colNum'] ) ? $settings['colNum'] : 24;
		$result['gutter']                              = isset( $settings['gutter'] ) ? $settings['gutter'] : 10;
		$result['gutter_tablet']                       = isset( $settings['gutter_tablet'] ) ? $settings['gutter_tablet'] : '';
		$result['gutter_mobile']                       = isset( $settings['gutter_mobile'] ) ? $settings['gutter_mobile'] : '';
		$result['vertical_compact']                    = isset( $settings['vertical_compact'] ) ? $settings['vertical_compact'] : false;
		$result['items_type']                          = isset( $settings['items_type'] ) ? $settings['items_type'] : 'default';
		$result['jetengine_listing_id']                = isset( $settings['jetengine_listing_id'] ) && 'jetengine_listing' === $settings['items_type'] ? esc_attr( $settings['jetengine_listing_id'] ) : false;
		$result['loading_spinner']                     = isset( $settings['loading_spinner'] ) ? $settings['loading_spinner'] : true;
		$result['loading_spinner_media']               = isset( $settings['loading_spinner_media'] ) ? $settings['loading_spinner_media'] : '';

		// item settings
		$result['item_thumbnail']                      = isset( $settings['item_thumbnail'] ) ? $settings['item_thumbnail'] : true;
		$result['item_thumbnail_size']                 = isset( $settings['item_thumbnail_size'] ) ? $settings['item_thumbnail_size'] : 'large';
		$result['item_term_taxonomy']                  = isset( $settings['item_term_taxonomy'] ) ? $settings['item_term_taxonomy'] : true;
		$result['item_title']                          = isset( $settings['item_title'] ) ? $settings['item_title'] : true;
		$result['item_description']                    = isset( $settings['item_description'] ) ? $settings['item_description'] : true;
		$result['item_description_words_count']        = isset( $settings['item_description_words_count'] ) ? $settings['item_description_words_count'] : 15;
		$result['item_description_words_count_tablet'] = isset( $settings['item_description_words_count_tablet'] ) ? $settings['item_description_words_count_tablet'] : 15;
		$result['item_description_words_count_mobile'] = isset( $settings['item_description_words_count_mobile'] ) ? $settings['item_description_words_count_mobile'] : 15;
		$result['item_post_count']                     = isset( $settings['item_post_count'] ) ? $settings['item_post_count'] : true;
		$result['item_posts_count_prefix']             = isset( $settings['item_posts_count_prefix'] ) ? $settings['item_posts_count_prefix'] : '';
		$result['item_divider']                        = isset( $settings['item_divider'] ) ? $settings['item_divider'] : true;

		$result = apply_filters( 'terms-grid-builder/data-settings', $result );

		return json_encode( $result );

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
