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
	require_once 'inc/Api.php';
	require_once 'inc/Menu.php';
	require_once 'inc/Manager.php';
	require_once 'inc/Helper.php';
	new Api();
	new Menu();
	new Manager();
	new Helper();

	require_once 'inc/apps/Customizer.php';
	new Customizer();
	require_once 'inc/apps/Log.php';
	new Log();
	require_once 'inc/apps/Hunt.php';
	new Hunt();
	require_once 'inc/apps/Avatar.php';
	new Avatar();

	require_once 'inc/feature/QuestManager.php';
	require_once 'inc/models/Quest.php';
	require_once 'inc/tasks/QuestContent.php';
	require_once 'inc/tasks/QuestPlugin.php';
	require_once 'inc/tasks/QuestTheme.php';
	require_once 'inc/tasks/QuestDate.php';
	require_once 'inc/tasks/QuestStart.php';
	new QuestManager();
	new QuestContent();
	new QuestPlugin();
	new QuestTheme();
	new QuestDate();
	new QuestStart();
}

add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );


function load_textdomain() {
	\load_plugin_textdomain( 'wapuugotchi', false, \dirname( \plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action( 'init', __NAMESPACE__ . '\load_textdomain' );
