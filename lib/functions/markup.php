<?php
/**
 * Markup
 *
 * @package     TimJensen\GenesisStarter
 * @since       0.1.0
 * @author      Tim Jensen
 * @link        https://www.timjensen.us
 * @license     GNU General Public License 2.0+
 */

namespace TimJensen\GenesisStarter;

add_filter( 'body_class', __NAMESPACE__ . '\\add_no_js_body_class' );
/**
 * Add 'no-js' class to the body class values.
 *
 * @author Gary Jones
 * @since 0.1.4
 *
 * @param array $classes Existing classes.
 * @return array
 */
function add_no_js_body_class( $classes ) {
	$classes[] = 'no-js';
	return $classes;
}

add_action( 'genesis_before', __NAMESPACE__ . '\\replace_no_js_body_class', 1 );
/**
 * Echos out the script that changes 'no-js' class to 'js'.
 *
 * @author Gary Jones
 * @since 0.1.4
 */
function replace_no_js_body_class() {
	?>
	<script type="text/javascript">
        //<![CDATA[
        (function(){
            var c = document.body.classList;
            c.remove('no-js');
            c.add('js');
        })();
        //]]>
	</script>
	<?php
}
