<?php
/**
 * Plugin Name:       WapuuGotchi
 * Description:       Meet Your Personalized Wapuu Assistant.
 * Requires at least: 6.0
 * Requires PHP:      7.2
 * Version:           0.2.0
 * Author:            wapuugotchi
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
		error_log("Wapuugotchi: $autoloader is not readable or does not exist");
		return;
	}

	require_once $autoloader;

	new \Wapuugotchi\Core\Menu();

	new \Wapuugotchi\Avatar\Manager();
	new \Wapuugotchi\Avatar\Api();

	new \Wapuugotchi\Shop\Manager();
	new \Wapuugotchi\Shop\Menu();
	new \Wapuugotchi\Shop\Api();

	new \Wapuugotchi\Quest\Manager();
	new \Wapuugotchi\Quest\Menu();
	new \Wapuugotchi\Quest\Filters\AutoMessage();
	new \Wapuugotchi\Quest\Filters\QuestContent();
	new \Wapuugotchi\Quest\Filters\QuestPlugin();
	new \Wapuugotchi\Quest\Filters\QuestTheme();
	new \Wapuugotchi\Quest\Filters\QuestDate();
	new \Wapuugotchi\Quest\Filters\QuestStart();

	new \Wapuugotchi\Onboarding\Manager();
	new \Wapuugotchi\Onboarding\Menu();
	new \Wapuugotchi\Onboarding\Filters\TourOrder();

	new \Wapuugotchi\Buddy\Manager();
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );
