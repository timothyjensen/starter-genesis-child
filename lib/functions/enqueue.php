<?php
/**
 * Asset loader handler.
 *
 * @package     TimJensen\GenesisStarter
 * @since       0.1.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter;

// Remove the child theme stylesheet that is loaded by Genesis so that we can enqueue a minified stylesheet.
remove_action( 'genesis_meta', 'genesis_load_stylesheet' );

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\\enqueue_assets' );
/**
 * Enqueue Scripts and Styles.
 *
 * @since 0.1.2
 *
 * @return void
 */
function enqueue_assets() {
	$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';

	wp_enqueue_style( 'starter-genesis-child-css', CHILD_THEME_URL . "/style{$suffix}.css", array(), filemtime( CHILD_THEME_DIR . '/style.css' ) );

	wp_enqueue_style( 'starter-genesis-child-fonts', '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700', array(), CHILD_THEME_VERSION );

	// wp_enqueue_style( 'dashicons' ); WPCS: ok.
	wp_enqueue_style( 'font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css' );

	wp_enqueue_script( 'starter-genesis-child-js', CHILD_THEME_URL . "/assets/js/theme{$suffix}.js", array( 'jquery' ), CHILD_THEME_VERSION, true );

	wp_localize_script(
		'starter-genesis-child-js',
		'genesis_responsive_menu',
		responsive_menu_settings()
	);
}

/**
 * Defines the responsive menu settings.
 *
 * @return array
 */
function responsive_menu_settings() {

	return array(
		'mainMenu'         => __( 'Menu', 'starter-genesis-child' ),
		'menuIconClass'    => 'fa fa-bars',
		'subMenu'          => __( 'Submenu', 'starter-genesis-child' ),
		'subMenuIconClass' => 'fa fa-caret-down',
		'menuClasses'      => array(
			'combine' => array(
				'.nav-primary',
				'.nav-header',
			),
			'others'  => array(),
		),
	);

}
