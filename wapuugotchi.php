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
	require_once 'inc/Api.php';
	require_once 'inc/Menu.php';
	require_once 'inc/Manager.php';
	new Api();
	new Menu();
	new Manager();

	require_once 'inc/feature/QuestManager.php';
	require_once 'inc/objects/Quest.php';
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

	require_once 'inc/feature/NotificationManager.php';
	require_once 'inc/objects/Notification.php';
	new NotificationManager();


}

add_action( 'plugins_loaded', 'Wapuugotchi\Wapuugotchi\init' );
