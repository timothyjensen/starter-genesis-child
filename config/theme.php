<?php
/**
 * Description
 *
 * @package     TimJensen\GenesisStarter
 * @since       1.0.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */
namespace TimJensen\GenesisStarter;

return [
	'navigation'     => [
		'primary'   => [
			'location' => 'header',
			'menu_name' => 'Header Menu'
		],
		'secondary' => [
			'location' => 'footer',
			'menu_name' => 'Footer Menu'
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
		'genesis-after-entry-widget-area' => null,
		'genesis-footer-widgets'          => 3,
		'genesis-menus'                   => [
			'primary'   => __( 'After Header Menu', CHILD_TEXT_DOMAIN ),
			'secondary' => __( 'Footer Menu', CHILD_TEXT_DOMAIN )
		],
	],
	'image_sizes'    => [
		'featured-image' => [
			'width'  => 720,
			'height' => 400,
			'crop'   => true,
		],
	],
];