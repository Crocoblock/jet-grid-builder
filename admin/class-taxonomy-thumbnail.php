<?php
namespace Posts_Grid_Builder;

/**
 * Taxonomy Thumbnail class
 */
// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}
/**
 * Define class
 */
class Taxonomy_Thumbnail {

	/**
	 * Holds the instances of this class.
	 *
	 * @var object
	 */
	private static $instance = null;
	
	public function __construct() {
		add_action( 'load-term.php', array( $this, 'add_field' ) );
		add_action( 'edited_term', array( $this, 'update_term_thumbnail' ), 10 );
	}
	
	// Add the field to the term form.
	public function add_field() {
		global $taxnow;

		$taxonomies = array_flip( $this->get_taxonomies() );

		if ( $taxnow && isset( $taxonomies[ $taxnow ] ) ) {
			// Edit term.
			add_action( $taxnow . '_edit_form', array( $this, 'edit_term_field' ), 20, 2 );
			// Styles and JavaScript.
			add_action( 'admin_enqueue_scripts', array( $this, 'styles_and_scripts' ) );
		}
	}

	// Update term action
	function update_term_thumbnail( $term_id ) {
		if ( empty( $_POST['action'] ) || ( 'add-tag' !== $_POST['action'] && 'editedtag' !== $_POST['action'] ) ) {
			return;
		}
	
		$thumbnail_id = absint( $_POST['jgb_term_thumbnail_id'] );

		if ( $thumbnail_id ) {
			update_term_meta( $term_id, 'jgb_term_thumbnail_id', $thumbnail_id );
		}
		else {
			delete_term_meta( $term_id, 'jgb_term_thumbnail_id' );
		}
	}

	/**
	 * Get taxonomies where the thumbnail UI will be displayed.
	 *
	 * @return (array) An array like `array( "category" => "category", "post_tag" => "post_tag" )`.
	 */
	public function get_taxonomies() {
		$taxonomies = get_taxonomies( array(
			'public'  => true,
			'show_ui' => true,
		) );

		/**
		 * Filter allowing to change the taxonomies for which to display thumbnail.
		 *
		 * @param (array) list of taxonomies.
		 */
		return apply_filters( 'posts-grid-builder/admin/taxonomy-thumbnail', $taxonomies );
	}

	/**
	 * Retrieve term thumbnail ID.
	 *
	 * @param (int) $term_id Term term_id.
	 *
	 * @return (int|false) The term thumbnail ID on success, false on failure.
	 */
	public function get_term_thumbnail_id( $term_id ) {
		$term_id = absint( $term_id );

		if ( $term_id ) {
			$thumbnail_id = get_term_meta( $term_id, 'jgb_term_thumbnail_id', true );
			return $thumbnail_id ? absint( $thumbnail_id ) : false;
		}

		return false;
	}

	/**
	 * Edit term.
	 *
	 * @param (object) $term     Current taxonomy term object.
	 * @param (string) $taxonomy Current taxonomy slug.
	 */
	function edit_term_field( $term, $taxonomy ) {
		$term_id       = absint( $term->term_id );
		$thumbnail_id  = $this->get_term_thumbnail_id( $term_id );
		$thumbnail_url = wp_get_attachment_image_url( $thumbnail_id, 'thumbnail' );

		?>
		<table class="form-table">
			<tbody>
				<tr class="form-field term-thumbnail-wrap">
					<th scope="row">
						<label for="thumbnail"><?php _e( 'Thumbnail for Terms Grid Builder' ); ?></label>
					</th>
					<td>
						<div id="thumbnail-field">
							<input id="thumbnail" class="hidden" type="number" name="jgb_term_thumbnail_id" value="<?php echo $thumbnail_id; ?>" autocomplete="off" title="<?php esc_attr_e( 'Indicate an image ID', 'jet-grid-builder' ); ?>" />
							<div class="attachment">
								<div class="attachment-preview">
									<div class="thumbnail">
										<div class="centered">
											<img src="<?php echo $thumbnail_url; ?>" draggable="false" alt="">
										</div>
									</div>
								</div>
							</div>
							<button type="button" class="add-term-thumbnail button button-large" id="thumbnail-button"><?php echo __( 'Set a thumbnail', 'jet-grid-builder' ); ?></button>
							<button type="button" class="remove-term-thumbnail button button-large"><?php echo __( 'Remove thumbnail', 'jet-grid-builder' ); ?></button>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
		<?php
	}

	/**
	 * Styles and scripts.
	 * 
	 * @return void
	 */
	function styles_and_scripts() {
		// CSS.
		wp_enqueue_style(
			'jgb-taxonomy-thumbnail-style',
			Plugin::instance()->assets_url( 'css/admin.css' ),
			false,
			JET_GRID_BUILDER_VERSION
		);

		// JS.
		wp_enqueue_media();
		wp_enqueue_script(
			'jgb-taxonomy-thumbnail-script',
			Plugin::instance()->assets_url( 'js/admin.js' ),
			array(
				'jquery',
				'media-editor'
			),
			JET_GRID_BUILDER_VERSION,
			true
		);
	}

	/**
	 * Returns the instance.
	 *
	 * @return object
	 */
	public static function instance() {
		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

}

Taxonomy_Thumbnail::instance();