<?php
/**
 * Menu HTML markup structure
 *
 * @package     TimJensen\GenesisStarter
 * @since       0.1.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter;

/**
 * Reduce the secondary navigation menu to one level depth.
 *
 * @since 0.1.0
 *
 * @param array $args Secondary nav menu arguments.
 * @return array
 */
function setup_secondary_menu_args( array $args ) {
	if ( 'secondary' !== $args['theme_location'] ) {
		return $args;
	}

	$args['depth'] = 1;

	return $args;
}
