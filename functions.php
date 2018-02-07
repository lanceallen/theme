<?php
/**
 * Theme
 *
 * @package     NickDavis\Theme
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\Theme;

/**
 * Initialise the theme's constants.
 *
 * @since 1.0.0
 *
 * @return void
 */
function init_constants() {
	$child_theme = wp_get_theme();

	define( 'CHILD_THEME_DIR', trailingslashit( get_stylesheet_directory() ) );
	define( 'CHILD_THEME_NAME', $child_theme->get( 'Name' ) );
	define( 'CHILD_THEME_URL', get_stylesheet_directory_uri() );
	define( 'CHILD_THEME_VERSION', filemtime( get_stylesheet_directory() . '/style.css' ) );

	define( 'CHILD_THEME_URI', get_stylesheet_directory_uri() );

	define( 'EXPIRATION', 3000 );
	define( 'TRANSIENT_PREFIX', 'text-domain' );
}

init_constants();

// Setup theme
include_once( CHILD_THEME_DIR . '/includes/setup.php' );

//add_action( 'after_setup_theme', __NAMESPACE__ . '\load_composer' );
/**
 * Loads Composer dependencies and Carbon Fields.
 *
 * NB. The composer files can be loaded earlier (e.g. plugins_loaded) but
 * Carbon Fields itself should be booted on after_setup_theme.
 *
 * @since 1.0.0
 */
function load_composer() {
	require_once CHILD_THEME_DIR . 'vendor/autoload.php';

	\Carbon_Fields\Carbon_Fields::boot();
}

/**
 * Start Genesis.
 *
 * @since 1.0.0
 */
include_once( get_template_directory() . '/lib/init.php' );

/**
 * Load theme modules.
 *
 * @since 1.0.0
 */
include CHILD_THEME_DIR . 'includes/assets.php';
