<?php
/**
 * Setup your child theme
 *
 * @package     TimJensen\GenesisStarter
 * @since       1.0.3
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */
namespace TimJensen\GenesisStarter\Setup;

/**
 * Setup child theme.
 *
 * @since 1.0.0
 *
 * @return void
 */
function setup_child_theme() {
	load_child_theme_textdomain( CHILD_TEXT_DOMAIN, apply_filters( 'child_theme_textdomain', CHILD_THEME_DIR . '/languages', CHILD_TEXT_DOMAIN ) );

	$config = include CHILD_CONFIG_DIR . 'theme-configuration.php';

	if ( ! empty( $config['navigation'] ) ) {
		setup_theme_navigation( $config['navigation'] );
	}

	if ( ! empty( $config['theme_supports'] ) ) {
		register_theme_supports( $config['theme_supports'] );
	}

	if ( ! empty( $config['image_sizes'] ) ) {
		register_new_image_sizes( $config['image_sizes'] );
	}

	if ( ! empty( $config['unregister_layouts'] ) ) {
		unregister_genesis_layouts( $config['unregister_layouts'] );
	}
}

setup_child_theme();

/**
 * Sets up the navigation menus
 *
 * @since 1.0.0
 *
 * @param array $theme_navigation_config
 *
 * @return void
 */
function setup_theme_navigation( $theme_navigation_config ) {

	if ( isset( $theme_navigation_config['primary'] ) ) {
		setup_primary_navigation( $theme_navigation_config['primary'] );
	}

	if ( isset( $theme_navigation_config['secondary'] ) ) {
		setup_secondary_navigation( $theme_navigation_config['secondary'] );
	}
}

/**
 * Configures the primary nav menu.
 *
 * @since 1.0.0
 *
 * @param array $primary_navigation_config
 *
 * @return void
 */
function setup_primary_navigation( $primary_navigation_config ) {

	$primary_menu_location = isset( $primary_navigation_config['location'] ) ? $primary_navigation_config['location'] : 'default';
	$responsive_navigation_style = isset( $primary_navigation_config['responsive-navigation-style'] ) ? $primary_navigation_config['responsive-navigation-style'] : 'default';

	if ( 'header' == $primary_menu_location ) {
		do_header_navigation();
	}

	if ( 'menu-overlay' == $responsive_navigation_style ) {
		add_genesis_contextual_classes( 'site-header', $responsive_navigation_style );
	}

}

/**
 * Add classes to Genesis contextual elements.
 *
 * @param string $context The HTML class of the container used as its identifier.
 * @param string $class  Class(es) to add
 */
function add_genesis_contextual_classes( $context, $class ) {

	// Add a class to the header.
	add_filter( "genesis_attr_{$context}", function ( $attributes ) use ( $class ) {

		$attributes['class'] .= " {$class}";

		return $attributes;
	} );
}

/**
 * Do the theme header navigation.
 */
function do_header_navigation() {

	// Remove the body class that is added by Genesis.
	add_filter( 'body_class', function ( $classes ) {

		if ( $key = array_search( 'header-full-width', $classes ) ) {
			unset( $classes[$key] );
		}

		return $classes;
	} );

	add_genesis_contextual_classes( 'site-header', 'header-nav' );

	// Remove the header right widget area.
	unregister_sidebar( 'header-right' );

	// Reposition nav.
	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_header', 'genesis_do_nav', 12 );
}

/**
 * Configures the secondary nav menu
 *
 * @since 1.0.0
 *
 * @param array $secondary_navigation_config
 *
 * @return void
 */
function setup_secondary_navigation( $secondary_navigation_config ) {

	$secondary_menu_location     = isset( $secondary_navigation_config['location'] ) ? $secondary_navigation_config['location'] : null;
	$secondary_menu_reduce_depth = isset( $secondary_navigation_config['reduce_depth'] ) ? $secondary_navigation_config['reduce_depth'] : false;

	if ( 'footer' === $secondary_menu_location ) {
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );
		add_action( 'genesis_footer', 'genesis_do_subnav', 5 );
	}

	if ( false !== $secondary_menu_reduce_depth ) {
		add_filter( 'wp_nav_menu_args', 'TimJensen\GenesisStarter\Menus\setup_secondary_menu_args' );
	}
}

/**
 * Adds theme supports to the site.
 *
 * @since 1.0.0
 *
 * @param array $theme_supports_config
 *
 * @return void
 */
function register_theme_supports( $theme_supports_config ) {

	foreach ( $theme_supports_config as $feature => $args ) {
		add_theme_support( $feature, $args );
	}
}

/**
 * Adds new image sizes.
 *
 * @since 1.0.0
 *
 * @param array $image_sizes_config
 *
 * @return void
 */
function register_new_image_sizes( $image_sizes_config ) {

	foreach ( $image_sizes_config as $name => $args ) {
		$crop = ! empty( $args['crop'] );

		add_image_size( $name, $args['width'], $args['height'], $crop );
	}
}

/**
 * Unregisters the specified Genesis layouts
 *
 * @since 1.0.0
 *
 * @param array $unregister_layouts_config
 *
 * @return void
 */
function unregister_genesis_layouts( $unregister_layouts_config ) {

	foreach ( $unregister_layouts_config as $layout ) {
		genesis_unregister_layout( $layout );
	}
}
