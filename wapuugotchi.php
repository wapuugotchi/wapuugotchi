<?php
/**
 * Plugin Name:       WapuuGotchi
 * Description:       Meet Your Personalized Wapuu Assistant.
 * Requires at least: 6.9
 * Requires PHP:      7.2
 * Version:           0.0.0
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

	spl_autoload_register( __NAMESPACE__ . '\\autoload' );

	// Core features.
	new \Wapuugotchi\Core\Menu();
	new \Wapuugotchi\Core\Settings();
	new \Wapuugotchi\Core\AdminBar();
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		new \Wapuugotchi\Core\Cli();
	}

	// Feature Manager.
	new \Wapuugotchi\Avatar\Manager();
	new \Wapuugotchi\Buddy\Manager();
	new \Wapuugotchi\Shop\Manager();
	new \Wapuugotchi\Quest\Manager();
	new \Wapuugotchi\Onboarding\Manager();
	new \Wapuugotchi\Alive\Manager();
	new \Wapuugotchi\Support\Manager();
	new \Wapuugotchi\Security\Manager();
	new \Wapuugotchi\Mission\Manager();
	new \Wapuugotchi\Quiz\Manager();
	new \Wapuugotchi\Hunt\Manager();
	new \Wapuugotchi\Sort\Manager();
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

/**
 * Autoloader for WapuuGotchi classes.
 *
 * @param string $class_name The fully-qualified class name.
 *
 * @return void
 */
function autoload( $class_name ) { // phpcs:ignore Generic.NamingConventions
	$prefix = 'Wapuugotchi\\';
	if ( strncmp( $prefix, $class_name, strlen( $prefix ) ) !== 0 ) {
		return;
	}

	$parts    = explode( '\\', substr( $class_name, strlen( $prefix ) ) );
	$filename = array_pop( $parts ) . '.php';
	$dirs     = array_map( 'strtolower', $parts );

	$base     = WAPUUGOTCHI_PATH . 'inc' . DIRECTORY_SEPARATOR;
	$rel_path = implode( DIRECTORY_SEPARATOR, $dirs ) . DIRECTORY_SEPARATOR . $filename;

	foreach ( array( $base . $rel_path, $base . 'games' . DIRECTORY_SEPARATOR . $rel_path ) as $file ) {
		if ( file_exists( $file ) ) {
			require $file;
			return;
		}
	}
}
