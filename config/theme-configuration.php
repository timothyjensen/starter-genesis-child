<?php
/**
 * Child theme configuration
 *
 * @package     TimJensen\GenesisStarter
 * @since       1.0.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter\ThemeConfig;

return [
	'navigation'         => [
		'primary'   => [
			'location'                    => 'header', // 'header', 'before_header', or default
			'responsive-navigation-style' => 'menu-overlay', // 'menu-overlay', or default
		],
		'secondary' => [
			'location'     => 'footer', // 'footer', or default
			'reduce_depth' => true,
		],
	],
	'add_theme_supports'     => [
		'html5'                           => [
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form',
		],
		'genesis-accessibility'           => [
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links',
		],
		'genesis-responsive-viewport'     => null,
		'custom-header'                   => [
			'width'           => 600,
			'height'          => 160,
			'header-selector' => '.site-title a',
			'header-text'     => false,
			'flex-height'     => true,
		],
		'genesis-footer-widgets'          => 1,
		'genesis-menus'                   => [
			'primary'   => __( 'Header Menu', CHILD_TEXT_DOMAIN ),
			'secondary' => __( 'Footer Menu', CHILD_TEXT_DOMAIN ),
		],
		'genesis-structural-wraps' => [
			'header',
			'menu-primary',
			'menu-secondary',
			'site-inner',
			'footer-widgets',
			'footer',
		],
	],
	'remove_theme_supports' => [
//		'genesis-after-entry-widget-area',
	],
	'image_sizes'        => [
		'featured-image' => [
			'width'  => 720,
			'height' => 400,
			'crop'   => true,
		],
	],
	'unregister_layouts' => [
		'content-sidebar-sidebar',
		'sidebar-sidebar-content',
		'sidebar-content-sidebar',
	],
	'remove_genesis_metaboxes'  => [
		'genesis-theme-settings-scripts',
		'genesis-theme-settings-blogpage',
	],
];
