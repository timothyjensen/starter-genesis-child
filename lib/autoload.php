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
 * Loads non admin files.
 *
 * @since 0.1.1
 *
 * @return void
 */
function load_nonadmin_files() {
	$files = [
		'setup',
		'functions/helpers',
		'functions/formatting',
		'functions/enqueue',
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
			include( $filename );
		}
	}
}
