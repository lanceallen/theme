<?php
/**
 * Theme setup and defaults
 *
 * @package     NickDavis\Theme
 * @since       1.0.0
 * @author      Nick Davis
 * @link        https://iamnickdavis.com
 * @license     GNU General Public License 2.0+
 */

namespace NickDavis\Theme;

add_action( 'genesis_setup', __NAMESPACE__ . '\setup_child_theme' );
/**
 * Setup child theme.
 *
 * @since 1.0.0
 *
 * @return void
 */
function setup_child_theme() {
	load_child_theme_textdomain( 'text-domain', apply_filters( 'child_theme_textdomain', CHILD_THEME_DIR . '/languages', 'text-domain' ) );

	adds_theme_supports();
	adds_new_image_sizes();
	removes_theme_supports();
}

/**
 * Adds theme supports to the site.
 *
 * @since 1.0.0
 *
 * @return void
 */
function adds_theme_supports() {
	$config = array(
		'html5'                       => array(
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form'
		),
		'genesis-accessibility'       => array(
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links'
		),
		'genesis-responsive-viewport' => null,
		'genesis_structural-wraps'    => array(
			'header',
			'footer-widgets',
			'footer'
		),
		'custom-header'               => array(
			'width'           => 600,
			'height'          => 160,
			'header-selector' => '.site-title a',
			'header-text'     => false,
			'flex-height'     => true,
		),
		'custom-background'           => null,
		'genesis-menus'               => array(
			'primary'       => __( 'Header', 'text-domain' ),
			'header-social' => __( 'Header Social', 'text-domain' ),
			'secondary'     => __( 'Footer', 'text-domain' ),
			'footer-social' => __( 'Footer Social', 'text-domain' ),
		),
	);

	foreach ( $config as $feature => $args ) {
		add_theme_support( $feature, $args );
	}
}

/**
 * Removes theme supports from the site.
 *
 * @since 1.0.0
 *
 * @return void
 */
function removes_theme_supports() {
	$config = array(
		'genesis-inpost-layouts',
	);

	foreach ( $config as $feature ) {
		remove_theme_support( $feature );
	}
}

/**
 * Adds new image sizes.
 *
 * @since 1.0.0
 *
 * @return void
 */
function adds_new_image_sizes() {
	$config = array(
//		'asset-one-col' => array(
//			'width'  => 720,
//			'height' => 720,
//			'crop'   => true,
//		),
//		'asset-two-col' => array(
//			'width'  => 360,
//			'height' => 360,
//			'crop'   => true,
//		),
	);

	foreach ( $config as $name => $args ) {
		$crop = array_key_exists( 'crop', $args ) ? $args['crop'] : false;

		add_image_size( $name, $args['width'], $args['height'], $crop );
	}
}

add_filter( 'genesis_theme_settings_defaults', __NAMESPACE__ . '\set_theme_settings_defaults' );
/**
 * Set theme settings defaults.
 *
 * @since 1.0.0
 *
 * @param array $defaults
 *
 * @return array
 */
function set_theme_settings_defaults( array $defaults ) {
	$config = get_theme_settings_defaults();

	$defaults = wp_parse_args( $config, $defaults );

	return $defaults;
}

add_action( 'after_switch_theme', __NAMESPACE__ . '\update_theme_settings_defaults' );
/**
 * Sets the theme setting defaults.
 *
 * @since 1.0.0
 *
 * @return void
 */
function update_theme_settings_defaults() {
	$config = get_theme_settings_defaults();

	if ( function_exists( 'genesis_update_settings' ) ) {
		genesis_update_settings( $config );
	}

	update_option( 'posts_per_page', $config['blog_cat_num'] );
}

/**
 * Get the theme settings defaults.
 *
 * @since 1.0.0
 *
 * @return array
 */
function get_theme_settings_defaults() {
	return array(
		'blog_cat_num'              => 12,
		'content_archive'           => 'full',
		'content_archive_limit'     => 0,
		'content_archive_thumbnail' => 0,
		'posts_nav'                 => 'numeric',
		'site_layout'               => 'full-width-content',
	);
}

add_filter( 'theme_page_templates', __NAMESPACE__ . '\remove_default_genesis_page_templates' );
/**
 * Remove Blog and Archive Template from Genesis.
 *
 * @since 1.0.0
 *
 * @param $templates
 *
 * @return mixed
 */
function remove_default_genesis_page_templates( $templates ) {
	unset( $templates['page_blog.php'] );
	unset( $templates['page_archive.php'] );

	return $templates;
}

add_action( 'genesis_admin_before_metaboxes', __NAMESPACE__ . '\remove_genesis_theme_settings_metaboxes' );
/**
 * Removes unused metaboxes from the Genesis > Theme Settings admin page.
 *
 * @since 1.0.0
 *
 * @param $hook
 */
function remove_genesis_theme_settings_metaboxes( $hook ) {
	$metaboxes = array(
//		'feeds',
//		'layout',
//		'nav',
//		'breadcrumb',
//		'comments',
//		'posts',
//		'blogpage'
	);

	foreach ( $metaboxes as $metabox ) {
		remove_meta_box( 'genesis-theme-settings-' . $metabox, $hook, 'main' );
	}
}

/**
 * Removes Edit link.
 *
 * @since 1.0.0
 */
add_filter( 'edit_post_link', '__return_false' );
