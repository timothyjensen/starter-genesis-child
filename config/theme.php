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
	'navigation'     => [
		'primary'   => [
			'location' => 'header',
		],
		'secondary' => [
			'location' => 'footer',
			'reduce_depth' => true,
		]
	],
	'theme_supports' => [
		'html5'                           => [
			'caption',
			'comment-form',
			'comment-list',
			'gallery',
			'search-form'
		],
		'genesis-accessibility'           => [
			'404-page',
			'drop-down-menu',
			'headings',
			'rems',
			'search-form',
			'skip-links'
		],
		'genesis-responsive-viewport'     => null,
		'custom-header'                   => [
			'width'           => 600,
			'height'          => 160,
			'header-selector' => '.site-title a',
			'header-text'     => false,
			'flex-height'     => true,
		],
		'custom-background'               => null,
		'genesis-after-entry-widget-area' => false,
		'genesis-footer-widgets'          => 1,
		'genesis-menus'                   => [
			'primary'   => __( 'Header Menu', CHILD_TEXT_DOMAIN ),
			'secondary' => __( 'Footer Menu', CHILD_TEXT_DOMAIN )
		],
		'genesis-structural-wraps' => [
			'header',
			'menu-primary',
			'menu-secondary',
			'site-inner',
			'footer-widgets',
			'footer'
		]
	],
	'image_sizes'    => [
		'featured-image' => [
			'width'  => 720,
			'height' => 400,
			'crop'   => true,
		],
	],
	'unregister_layouts' => [
		'content-sidebar-sidebar',
		'sidebar-sidebar-content',
		'sidebar-content-sidebar'
	],
];