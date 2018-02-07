<?php
/**
 * Load styles and scripts
 *
 * @package     NickDavis\Theme
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\Theme;

/**
 * Remove default stylesheet so you can override it with a minimised version.
 *
 * @link https://chriswiegman.com/2013/06/remove-the-default-style-css-in-wordpress-with-genesis/
 *
 * @since 1.0.0
 */
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\enqueue_admin_assets' );
/**
 * Enqueues admin assets.
 *
 * @since 1.0.0
 *
 * @return void
 */
function enqueue_admin_assets() {
	wp_enqueue_script( 'text-domain-admin', CHILD_THEME_URL . '/assets/js/admin.min.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue_assets' );
/**
 * Enqueue scripts and styles.
 *
 * @since 1.0.0
 *
 * @return void
 */
function enqueue_assets() {
	//wp_enqueue_style( 'google-fonts', '//fonts.googleapis.com/css?family=Nunito+Sans:400,400i,600,700,700i|Sorts+Mill+Goudy:400,400i', array(), CHILD_THEME_VERSION );

	wp_enqueue_style( 'text-domain', get_stylesheet_directory_uri() . '/style.min.css', array(), CHILD_THEME_VERSION );

	wp_enqueue_script( 'text-domain-vendor', CHILD_THEME_URL . '/assets/js/vendor.js', array( 'jquery' ), CHILD_THEME_VERSION, true );
	wp_enqueue_script( 'text-domain-custom', CHILD_THEME_URL . '/assets/js/custom.js', array(
		'jquery',
		'text-domain-vendor'
	), CHILD_THEME_VERSION, true );
}
