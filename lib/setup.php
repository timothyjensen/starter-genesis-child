<?php
/**
 * Sets up the child theme.
 *
 * @package     TimJensen\GenesisStarter
 * @since       0.1.3
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter;

/**
 * Setup child theme.
 *
 * @since 0.1.0
 *
 * @return void
 */
function setup_child_theme() {
	load_child_theme_textdomain( 'starter-genesis-child', apply_filters( 'starter_genesis_child', CHILD_THEME_DIR . '/languages', 'starter-genesis-child' ) );

	add_widget_text_shortcode_support();

	replace_genesis_favicon();

	do_theme_configuration();
}

setup_child_theme();

/**
 * Implements the arguments setup in the theme configuration file.
 *
 * @since 0.1.1
 *
 * @return void
 */
function do_theme_configuration() {

	$config = include CHILD_CONFIG_DIR . '/theme-configuration.php';

	foreach ( (array) $config as $callback => $args ) {

		if ( empty( $args ) || false === function_exists( __NAMESPACE__ . "\\$callback" ) ) {
			continue;
		}

		call_user_func_array( __NAMESPACE__ . "\\$callback", [ $args ] );
	}
}

/**
 * Sets the site header as sticky or default.
 *
 * @since 0.1.4
 *
 * @param array $theme_header_config Theme header configuration.
 * @return void
 */
function header( array $theme_header_config ) {
	if ( isset( $theme_header_config['position'] ) ) {

		add_filter(
			'body_class',
			function( $classes ) use ( $theme_header_config ) {
				$classes[] = $theme_header_config['position'] . '-header';

				return $classes;
			}
		);
	}
}

/**
 * Sets up the navigation menus
 *
 * @since 0.1.0
 *
 * @param array $theme_navigation_config Theme navigation configuration array.
 *
 * @return void
 */
function navigation( array $theme_navigation_config ) {

	foreach ( (array) $theme_navigation_config as $menu_location => $menu_arguments ) {
		$setup_navigation_callback = __NAMESPACE__ . "\\setup_{$menu_location}_navigation";

		if ( function_exists( $setup_navigation_callback ) ) {
			call_user_func_array( $setup_navigation_callback, [ $menu_arguments ] );
		}
	}
}

/**
 * Configures the primary nav menu.
 *
 * @since 0.1.0
 *
 * @param array $primary_navigation_config Primary navigation configuration array.
 *
 * @return void
 */
function setup_primary_navigation( array $primary_navigation_config ) {

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
	add_filter(
		"genesis_attr_{$context}", function ( $attributes ) use ( $class ) {

			$attributes['class'] .= " {$class}";

			return $attributes;
		}
	);
}

/**
 * Do the theme header navigation.
 */
function do_header_navigation() {

	// Remove the body class that is added by Genesis.
	add_filter(
		'body_class', function ( $classes ) {

			$key = array_search( 'header-full-width', $classes, true );

			if ( false !== $key ) {
				unset( $classes[ $key ] );
			}

			return $classes;
		}
	);

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
 * @since 0.1.1
 */
function do_before_header_navigation() {

	remove_action( 'genesis_after_header', 'genesis_do_nav' );
	add_action( 'genesis_before_header', 'genesis_do_nav' );
}

/**
 * Configures the secondary nav menu
 *
 * @since 0.1.0
 *
 * @param array $secondary_navigation_config Secondary navigation configuration array.
 *
 * @return void
 */
function setup_secondary_navigation( array $secondary_navigation_config ) {

	$secondary_menu_location     = isset( $secondary_navigation_config['location'] ) ? $secondary_navigation_config['location'] : null;
	$secondary_menu_reduce_depth = isset( $secondary_navigation_config['reduce_depth'] ) ? $secondary_navigation_config['reduce_depth'] : false;

	if ( 'footer' === $secondary_menu_location ) {
		remove_action( 'genesis_after_header', 'genesis_do_subnav' );
		add_action( 'genesis_footer', 'genesis_do_subnav', 5 );
	}

	if ( false !== $secondary_menu_reduce_depth ) {
		add_filter( 'wp_nav_menu_args', 'TimJensen\GenesisStarter\setup_secondary_menu_args' );
	}
}

/**
 * Adds theme supports to the site.
 *
 * @since 0.1.0
 *
 * @param array $add_theme_supports_config Array of theme supports to add.
 *
 * @return void
 */
function add_theme_supports( array $add_theme_supports_config ) {

	foreach ( (array) $add_theme_supports_config as $feature => $args ) {

		add_theme_support( $feature, $args );
	}
}

/**
 * Removes theme supports from the site.
 *
 * @since 0.1.0
 *
 * @param array $remove_theme_supports_config Array of theme supports to remove.
 *
 * @return void
 */
function remove_theme_supports( array $remove_theme_supports_config ) {

	foreach ( (array) $remove_theme_supports_config as $feature ) {

		remove_theme_support( $feature );
	}
}

/**
 * Adds new image sizes.
 *
 * @since 0.1.0
 *
 * @param array $image_sizes_config Name and arguments for the new image size(s).
 *
 * @return void
 */
function add_image_sizes( array $image_sizes_config ) {

	foreach ( (array) $image_sizes_config as $name => $args ) {
		$crop = ! empty( $args['crop'] );

		add_image_size( $name, $args['width'], $args['height'], $crop );
	}
}

/**
 * Unregisters the specified Genesis layouts
 *
 * @since 0.1.0
 *
 * @param array $unregister_layouts_config Genesis layout ids.
 *
 * @return void
 */
function genesis_unregister_layouts( array $unregister_layouts_config ) {

	foreach ( (array) $unregister_layouts_config as $layout ) {

		genesis_unregister_layout( $layout );
	}
}

/**
 * Registers new widget areas.
 *
 * @param array $register_widgets_config Widget area configuration.
 * @return void
 */
function genesis_register_widget_areas( array $register_widgets_config ) {

	foreach ( (array) $register_widgets_config as $widget ) {

		genesis_register_widget_area( $widget );
	}
}

/**
 * Unregisters the specified Genesis sidebars
 *
 * @since 0.1.0
 *
 * @param array $unregister_sidebars_config Array of sidebars to unregister.
 *
 * @return void
 */
function unregister_sidebars( array $unregister_sidebars_config ) {

	foreach ( (array) $unregister_sidebars_config as $sidebar ) {

		unregister_sidebar( $sidebar );
	}
}

/**
 * Removes the specified Genesis theme settings metaboxes.
 *
 * @since 0.1.0
 *
 * @param array $remove_theme_settings_metaboxes_config Genesis Theme Settings metabox IDs.
 *
 * @return void
 */
function remove_genesis_theme_settings_metaboxes( array $remove_theme_settings_metaboxes_config ) {

	add_action(
		'genesis_theme_settings_metaboxes', function ( $pagehook ) use ( $remove_theme_settings_metaboxes_config ) {

			foreach ( (array) $remove_theme_settings_metaboxes_config as $metabox ) {

				remove_meta_box( $metabox, $pagehook, 'main' );
			}
		}
	);
}

/**
 * Removes Genesis inpost metaboxes.
 *
 * @since 0.1.0
 *
 * @param array $remove_genesis_inpost_metaboxes_config Genesis metabox callback functions to remove.
 *
 * @return void
 */
function remove_genesis_inpost_metaboxes( array $remove_genesis_inpost_metaboxes_config ) {

	foreach ( (array) $remove_genesis_inpost_metaboxes_config as $metabox_callback ) {

		remove_action( 'admin_menu', "{$metabox_callback}" );
	}
}

/**
 * Add supports for shortcodes in text widgets.
 *
 * @since 0.1.0
 *
 * @return void
 */
function add_widget_text_shortcode_support() {

	add_filter( 'widget_text', 'do_shortcode' );
}

/**
 * Replaces the default Genesis favicon.
 *
 * @since 0.1.0
 *
 * @return void
 */
function replace_genesis_favicon() {

	/**
	 * Use the favicon in the theme's assets folder.
	 *
	 * @return string
	 */
	add_filter(
		'genesis_pre_load_favicon',
		function () {
			return CHILD_THEME_URL . '/assets/images/favicon.ico';
		}
	);
}

add_filter( 'acf/settings/save_json', __NAMESPACE__ . '\\acf_json_save_path' );
/**
 * Changes the default path for saving ACF field group configuration files.
 *
 * @return string
 */
function acf_json_save_path() {
	return CHILD_CONFIG_DIR . '/acf-json';
}
