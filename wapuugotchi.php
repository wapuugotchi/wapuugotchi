<?php
/**
 * Plugin Name:       WapuuGotchi
 * Description:       Meet Your Personalized Wapuu Assistant.
 * Requires at least: 6.0
 * Requires PHP:      7.0
 * Version:           0.1.5
 * Author:            herrfeldmann
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       wapuugotchi
 *
 * @package           create-block
 */

namespace Wapuugotchi\Wapuugotchi;

use Wapuugotchi\Wapuugotchi\Apps\Avatar;
use Wapuugotchi\Wapuugotchi\Apps\Customizer;
use Wapuugotchi\Wapuugotchi\Apps\Log;
use Wapuugotchi\Wapuugotchi\Feature\QuestManager;
use Wapuugotchi\Wapuugotchi\Tasks\QuestContent;
use Wapuugotchi\Wapuugotchi\Tasks\QuestDate;
use Wapuugotchi\Wapuugotchi\Tasks\QuestPlugin;
use Wapuugotchi\Wapuugotchi\Tasks\QuestStart;
use Wapuugotchi\Wapuugotchi\Tasks\QuestTheme;

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

	new Api();
	new Menu();
	new Manager();

	new Customizer();
	new Log();
	new Avatar();

	new QuestManager();
	new QuestContent();
	new QuestPlugin();
	new QuestTheme();
	new QuestDate();
	new QuestStart();
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );

/**
 * Load plugin text domain.
 */
function load_textdomain() {
	\load_plugin_textdomain( 'wapuugotchi', false, \dirname( \plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'init', __NAMESPACE__ . '\load_textdomain' );
