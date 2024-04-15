<?php
/**
 * Plugin Name:       WapuuGotchi
 * Description:       Meet Your Personalized Wapuu Assistant.
 * Requires at least: 6.0
 * Requires PHP:      7.0
 * Version:           0.2.0
 * Author:            herrfeldmann
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wapuugotchi
 *
 * @package           create-block
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'WAPUUGOTCHI_PATH' ) ) {
	define( 'WAPUUGOTCHI_PATH', \plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WAPUUGOTCHI_URL' ) ) {
	define( 'WAPUUGOTCHI_URL', \plugin_dir_url( __FILE__ ) );
}

if ( ! defined( 'WAPUUGOTCHI_SLUG' ) ) {
	define( 'WAPUUGOTCHI_SLUG', \plugin_basename( __DIR__ . '/wapuugotchi.php' ) );
}
if ( is_readable( WAPUUGOTCHI_PATH . 'vendor/autoload.php' ) ) {
	require WAPUUGOTCHI_PATH . 'vendor/autoload.php';
}
/**
 * Init plugin.
 *
 * @return void
 */
function init() {
	/**
	 * Implements the composer autoloader if not already done.
	 */
	if ( is_readable( WAPUUGOTCHI_PATH . 'vendor/autoload.php' ) ) {
		require_once WAPUUGOTCHI_PATH . 'vendor/autoload.php';
	}

	new \Wapuugotchi\Avatar\Manager();
	new \Wapuugotchi\Avatar\Api();
	new \Wapuugotchi\Avatar\Filters\Messages();


}

add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );
