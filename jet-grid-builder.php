<?php
/**
 * Plugin Name: JetGridBuilder
 * Description: Addon for creating wow-grids on your website
 * Plugin URI:  https://crocoblock.com/plugins/jetgridbuilder/
 * Version:     1.1.0
 * Author:      Crocoblock
 * Author URI:  https://crocoblock.com/
 * Text Domain: jet-grid-builder
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die();
}

define( 'JET_GRID_BUILDER_VERSION', '1.1.0' );
define( 'JET_GRID_BUILDER__FILE__', __FILE__ );
define( 'JET_GRID_BUILDER_PLUGIN_BASE', plugin_basename( JET_GRID_BUILDER__FILE__ ) );
define( 'JET_GRID_BUILDER_PATH', plugin_dir_path( JET_GRID_BUILDER__FILE__ ) );
define( 'JET_GRID_BUILDER_URL', plugins_url( '/', JET_GRID_BUILDER__FILE__ ) );

//Other constants
$upload_dir = wp_upload_dir();
if ( ! defined( 'UPLOAD_BASE_DIR' ) ) {
	define( 'UPLOAD_BASE_DIR', str_replace( "\\", "/", $upload_dir['basedir'] ) );
}
if ( ! defined( 'UPLOAD_BASE_URL' ) ) {
	define( 'UPLOAD_BASE_URL', $upload_dir['baseurl'] );
}

if ( ! version_compare( PHP_VERSION, '5.4', '>=' ) ) {
	add_action( 'admin_notices', 'jet_grid_builder_fail_php_version' );
} elseif ( ! version_compare( get_bloginfo( 'version' ), '4.6', '>=' ) ) {
	add_action( 'admin_notices', 'jet_grid_builder_fail_wp_version' );
} else {
	require( JET_GRID_BUILDER_PATH . 'includes/plugin.php' );
	if ( is_admin() ) {
		require( JET_GRID_BUILDER_PATH . 'admin/class-taxonomy-thumbnail.php' );
	}
}

/**
 * Admin notice for minimum PHP version.
 *
 * Warning when the site doesn't have the minimum required PHP version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jet_grid_builder_fail_php_version() {
	$message      = esc_html__( 'Jet Grid Builder requires PHP version 5.4+, plugin is currently NOT ACTIVE.', 'jet-grid-builder' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );
}

/**
 * Admin notice for minimum WordPress version.
 *
 * Warning when the site doesn't have the minimum required WordPress version.
 *
 * @since 1.0.0
 *
 * @return void
 */
function jet_grid_builder_fail_wp_version() {

	$message = esc_html__( 'Jet Grid Builder requires WordPress version 4.6+. Because you are using an earlier version, the plugin is currently NOT ACTIVE.', 'jet-grid-builder' );
	$html_message = sprintf( '<div class="error">%s</div>', wpautop( $message ) );
	echo wp_kses_post( $html_message );

}