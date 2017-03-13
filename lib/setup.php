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
namespace TimJensen\GenesisStarter;

/**
 * Setup child theme.
 *
 * @since 1.0.0
 *
 * @return void
 */
function setup_child_theme() {
	load_child_theme_textdomain( CHILD_TEXT_DOMAIN, apply_filters( 'child_theme_textdomain', CHILD_THEME_DIR . '/languages', CHILD_TEXT_DOMAIN ) );

	$config = include CHILD_CONFIG_DIR . 'theme.php';

	if ( ! empty( $config['navigation'] ) ) {
		setup_theme_navigation( $config['navigation'] );
	}

	if ( ! empty( $config['theme_supports'] ) ) {
		register_theme_supports( $config['theme_supports'] );
	}

	if ( ! empty( $config['image_sizes'] ) ) {
		register_new_image_sizes( $config['image_sizes'] );
	}
}

setup_child_theme();

/**
 * Sets up the location of the navigation menus
 *
 * @since 1.0.0
 *
 * @param array $theme_navigation_config
 *
 * @return void
 */
function setup_theme_navigation( $theme_navigation_config ) {

	foreach ( $theme_navigation_config as $nav_menu_name => $location ) {

		add_filter( 'body_class', function( $classes ) use ( $nav_menu_name, $location ) {
			$classes[] = esc_attr( "{$nav_menu_name}-navigation-{$location['location']}" );

			return $classes;
		} );
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
