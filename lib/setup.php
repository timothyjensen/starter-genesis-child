<?php
/**
 * Set up the child theme
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

	if ( ! empty( $config['add_theme_supports'] ) ) {
		add_theme_supports( $config['add_theme_supports'] );
	}

	if ( ! empty( $config['remove_theme_supports'] ) ) {
		remove_theme_supports( $config['remove_theme_supports'] );
	}

	if ( ! empty( $config['image_sizes'] ) ) {
		register_new_image_sizes( $config['image_sizes'] );
	}

	if ( ! empty( $config['unregister_layouts'] ) ) {
		unregister_genesis_layouts( $config['unregister_layouts'] );
	}

	if ( ! empty( $config['unregister_sidebars'] ) ) {
		unregister_sidebars( $config['unregister_sidebars'] );
	}

	if ( ! empty( $config['remove_genesis_metaboxes'] ) ) {
		remove_genesis_theme_metaboxes( $config['remove_genesis_metaboxes'] );
	}
}

setup_child_theme();

/**
 * Sets up the navigation menus
 *
 * @since 1.0.0
 *
 * @param array $theme_navigation_config Theme navigation configuration array.
 *
 * @return void
 */
function setup_theme_navigation( array $theme_navigation_config ) {

	foreach ( (array) $theme_navigation_config as $menu_location => $menu_arguments ) {

		$setup_navigation_callback = __NAMESPACE__ . "\\setup_{$menu_location}_navigation";

		if ( function_exists( $setup_navigation_callback ) ) {

			call_user_func_array( $setup_navigation_callback,  [ $menu_arguments ] );
		}
	}
}

/**
 * Configures the primary nav menu.
 *
 * @since 1.0.0
 *
 * @param array $primary_navigation_config Primary navigation configuration array.
 *
 * @return void
 */
function setup_primary_navigation( $primary_navigation_config ) {

	$primary_menu_location       = isset( $primary_navigation_config['location'] ) ? $primary_navigation_config['location'] : 'default';
	$responsive_navigation_style = isset( $primary_navigation_config['responsive-navigation-style'] ) ? $primary_navigation_config['responsive-navigation-style'] : 'default';

	if ( function_exists( __NAMESPACE__ . "\\do_{$primary_menu_location}_navigation" ) ) {
		call_user_func( __NAMESPACE__ . "\\do_{$primary_menu_location}_navigation" );
	}

	if ( 'menu-overlay' === $responsive_navigation_style ) {
		add_genesis_contextual_classes( 'site-header', $responsive_navigation_style );
	}
}

/**
 * Add classes to Genesis contextual elements.
 *
 * @param string $context The HTML class of the container used as its identifier.
 * @param string $class   Class(es) to add.
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

		$key = array_search( 'header-full-width', $classes, true );

		if ( false !== $key ) {
			unset( $classes[ $key ] );
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
 * Do the before header navigation.
 *
 * @since 1.0.1
 */
function do_before_header_navigation() {

	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_before_header', 'genesis_do_nav' );
}

/**
 * Configures the secondary nav menu
 *
 * @since 1.0.0
 *
 * @param array $secondary_navigation_config Secondary navigation configuration array.
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
 * @param array $add_theme_supports_config Array of theme supports to add.
 *
 * @return void
 */
function add_theme_supports( $add_theme_supports_config ) {

	foreach ( $add_theme_supports_config as $feature => $args ) {
		add_theme_support( $feature, $args );
	}
}

/**
 * Removes theme supports from the site.
 *
 * @since 1.0.0
 *
 * @param array $remove_theme_supports_config Array of theme supports to remove.
 *
 * @return void
 */
function remove_theme_supports( $remove_theme_supports_config ) {

	foreach ( $remove_theme_supports_config as $feature ) {
		remove_theme_support( $feature );
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

/**
 * Unregisters the specified Genesis sidebars
 *
 * @since 1.0.0
 *
 * @param array $unregister_sidebars_config Array of sidebars to unregister.
 *
 * @return void
 */
function unregister_sidebars( $unregister_sidebars_config ) {

	foreach ( $unregister_sidebars_config as $sidebar ) {
		unregister_sidebar( $sidebar );
	}
}

/**
 * Removes the specified Genesis theme settings metaboxes.
 *
 * @since 1.0.0
 *
 * @param array $remove_metaboxes_config Genesis Theme Settings metabox IDs.
 *
 * @return void
 */
function remove_genesis_theme_metaboxes( $remove_metaboxes_config ) {

	add_action( 'genesis_theme_settings_metaboxes', function ( $pagehook ) use ( $remove_metaboxes_config ) {

		foreach ( $remove_metaboxes_config as $metabox ) {
			remove_meta_box( $metabox, $pagehook, 'main' );
		}
	} );
}
