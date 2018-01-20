<?php
/**
 * File autoloader
 *
 * @package     TimJensen\GenesisStarter
 * @since       0.1.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter;

/**
 * Loads theme files.
 *
 * @since 0.1.1
 *
 * @return void
 */
function autoload() {
	$files = [
		'vendor/autoload', // Load before others.
		'setup', // Load before others.
		'functions/enqueue',
		'functions/formatting',
		'functions/helpers',
		'functions/markup',
		'structure/archive',
		'structure/comments',
		'structure/footer',
		'structure/header',
		'structure/menu',
		'structure/post',
		'structure/sidebar',
	];

	foreach ( (array) $files as $file ) {
		$filename = __DIR__ . '/' . $file . '.php';

		if ( file_exists( $filename ) ) {
			require_once $filename;
		}
	}
}

autoload();
