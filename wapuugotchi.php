<?php
/**
 * Plugin Name:       WapuuGotchi
 * Description:       Meet Your Personalized Wapuu Assistant.
 * Requires at least: 6.8
 * Requires PHP:      7.2
 * Version:           1.3.1
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

	// Initialize security features.
	\Wapuugotchi\Core\Security::init();

	// Core features.
	new \Wapuugotchi\Core\Menu();
	new \Wapuugotchi\Core\AdminBar();

	new \Wapuugotchi\Avatar\Manager();
	new \Wapuugotchi\Buddy\Manager();
	new \Wapuugotchi\Shop\Manager();
	new \Wapuugotchi\Quest\Manager();
	new \Wapuugotchi\Onboarding\Manager();
	new \Wapuugotchi\Alive\Manager();

	// Mission feature and the associated games.
	new \Wapuugotchi\Mission\Manager();
	new \Wapuugotchi\Quiz\Manager();
	new \Wapuugotchi\Hunt\Manager();
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );

/*
	Use local textdomain only in case that
	there is no official translation.
*/
\add_action(
	'init',
	function () {
		\load_plugin_textdomain( 'wapuugotchi-local', false, \dirname( WAPUUGOTCHI_SLUG ) . '/languages' );
	}
);
\add_filter(
	'gettext',
	function ( $translated_text, $text, $domain ) {
		if ( 'wapuugotchi' === $domain && $text === $translated_text ) {
			// phpcs:ignore WordPress.WP
			return \__( $text, 'wapuugotchi-local' );
		}

		return $translated_text;
	},
	100,
	3
);
