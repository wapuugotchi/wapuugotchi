<?php
/**
 * Plugin Name:       Wapuugotchi
 * Description:       Meet Your Personalized Wapuu Assistant.
 * Requires at least: 5.9
 * Requires PHP:      7.0
 * Version:           0.1.0
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wapuugotchi
 *
 * @package           create-block
 */

namespace Wapuugotchi\Wapuugotchi;

/**
 * Init plugin.
 *
 * @return void
 */
function init() {
	require_once 'inc/class-api.php';
	new Api();

	require_once 'inc/class-manager.php';
	new Manager();

	require_once 'inc/class-menu.php';
	new Menu();
}

add_action( 'plugins_loaded', 'Wapuugotchi\Wapuugotchi\init' );
