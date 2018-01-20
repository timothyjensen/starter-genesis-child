<?php
/**
 * Developer's Theme
 *
 * @package     TimJensen\GenesisStarter
 * @since       0.1.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter;

$starter_genesis_child = wp_get_theme();

define( 'CHILD_THEME_NAME', $starter_genesis_child->get( 'Name' ) );
define( 'CHILD_THEME_URL', get_stylesheet_directory_uri() );
define( 'CHILD_THEME_VERSION', $starter_genesis_child->get( 'Version' ) );
define( 'CHILD_THEME_DIR', __DIR__ );
define( 'CHILD_CONFIG_DIR', __DIR__ . '/config' );

// Start the Genesis engine.
require_once get_template_directory() . '/lib/init.php';
require_once __DIR__ . '/lib/autoload.php';
