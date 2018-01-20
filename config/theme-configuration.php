<?php
/**
 * Child theme configuration
 *
 * @package     TimJensen\GenesisStarter
 * @since       0.1.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter;

return [
	'header'                                  => [
		'position' => 'sticky', // sticky, or default
	],
	'navigation'                              => [
		'primary'   => [
			'location'                    => 'header', // 'header', 'before_header', or default
			'responsive-navigation-style' => 'menu-overlay', // 'menu-overlay', or default
		],
		'secondary' => [
			'location'     => 'footer', // 'footer', or default
			'reduce_depth' => true,
		],
	],
	'add_theme_supports'                      => [
		'html5'                       => [
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form',
		],
		'genesis-accessibility'       => [
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links',
		],
		'genesis-responsive-viewport' => null,
		'custom-header'               => [
			'width'           => 300,
			'height'          => 80,
			'header-selector' => '.site-title a',
			'header-text'     => false,
			'flex-height'     => true,
		],
		'genesis-footer-widgets'      => 1,
		'genesis-menus'               => [
			'primary'   => __( 'Header Menu', 'starter-genesis-child' ),
			'secondary' => __( 'Footer Menu', 'starter-genesis-child' ),
		],
		'genesis-structural-wraps'    => [
			'header',
			'menu-primary',
			'menu-secondary',
			'site-inner',
			'footer-widgets',
			'footer',
		],
	],
	'remove_theme_supports'                   => [
		// 'genesis-after-entry-widget-area',
	],
	'add_image_sizes'                         => [
		// 'featured-image' => [
		// 'width'  => 720,
		// 'height' => 400,
		// 'crop'   => true,
		// ],
	],
	'genesis_unregister_layouts'              => [
		'content-sidebar-sidebar',
		'sidebar-sidebar-content',
		'sidebar-content-sidebar',
	],
	'genesis_register_widget_areas'           => [
		[
			'id'          => 'page-top-widget-area',
			'name'        => __( 'Page Top', 'starter-genesis-child' ),
			'description' => __( 'Appears at the topmost section of each page.', 'starter-genesis-child' ),
		],
	],
	'unregister_sidebars'                     => [
		'sidebar-alt',
	],
	'remove_genesis_theme_settings_metaboxes' => [
		'genesis-theme-settings-scripts',
		'genesis-theme-settings-blogpage',
	],
	'remove_genesis_inpost_metaboxes'         => [
		'genesis_add_inpost_seo_box',
		// 'genesis_add_inpost_layout_box',
		'genesis_add_inpost_scripts_box',
	],
];
