<?php
/**
 * Plugin Name:       WapuuGotchi
 * Description:       Meet Your Personalized Wapuu Assistant.
 * Requires at least: 6.2
 * Requires PHP:      8.0
 * Version:           1.1.1
 * Author:            wapuugotchi
 * Author URI:        https://wapuugotchi.com/
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
	\define( 'WAPUUGOTCHI_PATH', \plugin_dir_path( __FILE__ ) );
	\define( 'WAPUUGOTCHI_URL', \plugin_dir_url( __FILE__ ) );
	\define( 'WAPUUGOTCHI_SLUG', \plugin_basename( __DIR__ . '/wapuugotchi.php' ) );

	$autoloader = WAPUUGOTCHI_PATH . 'vendor/autoload.php';
	if ( ! \is_readable( $autoloader ) ) {
		return;
	}

	require_once $autoloader;

	new \Wapuugotchi\Core\Menu();
	new \Wapuugotchi\Avatar\Manager();
	new \Wapuugotchi\Buddy\Manager();
	new \Wapuugotchi\Shop\Manager();
	new \Wapuugotchi\Quest\Manager();
	new \Wapuugotchi\Onboarding\Manager();
	new \Wapuugotchi\Alive\Manager();
	new \Wapuugotchi\Mission\Manager();
	new \Wapuugotchi\Quiz\Manager();
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );
