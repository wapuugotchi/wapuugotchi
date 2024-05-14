<?php
/**
 * The Log Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest;

use Wapuugotchi\Quest\Data\AutoMessage;
use Wapuugotchi\Quest\Data\QuestContent;
use Wapuugotchi\Quest\Data\QuestDate;
use Wapuugotchi\Quest\Data\QuestPlugin;
use Wapuugotchi\Quest\Data\QuestStart;
use Wapuugotchi\Quest\Data\QuestTheme;
use Wapuugotchi\Quest\Handler\QuestHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Log
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_bubble_messages', array( AutoMessage::class, 'add_wapuugotchi_messages' ), PHP_INT_MAX, 1 );

		$this->load_quests();
		\add_action( 'admin_init', array( QuestHandler::class, 'manage_quest_progress' ), 1000, 0 );
		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 20 );
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Initialization Manager
	 *
	 * @param string $hook_suffix The internal page name.
	 *
	 * @return void
	 */
	public function load_scripts( $hook_suffix ) {
		if ( 'wapuugotchi_page_wapuugotchi__quests' !== $hook_suffix ) {
			return;
		}

		$assets = include_once WAPUUGOTCHI_PATH . 'build/quest.asset.php';
		\wp_enqueue_style( 'wapuugotchi-quest', WAPUUGOTCHI_URL . 'build/quest.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-quest', WAPUUGOTCHI_URL . 'build/quest.js', $assets['dependencies'], $assets['version'], true );
		\wp_add_inline_script(
			'wapuugotchi-quest',
			'window.extWapuugotchiLogData = ' . \wp_json_encode(
				array(
					'active_quests'    => QuestHandler::get_active_quests(),
					'completed_quests' => QuestHandler::get_completed_quests(),
				)
			),
			'before'
		);

		\wp_set_script_translations( 'wapuugotchi-quest', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	/**
	 * Load Quests
	 */
	public function load_quests() {
		\add_filter( 'wapuugotchi_quest_filter', array( QuestContent::class, 'add_wapuugotchi_filter' ), 10, 1 );
		\add_filter( 'wapuugotchi_quest_filter', array( QuestPlugin::class, 'add_wapuugotchi_filter' ), 10, 1 );
		\add_filter( 'wapuugotchi_quest_filter', array( QuestTheme::class, 'add_wapuugotchi_filter' ), 10, 1 );
		\add_filter( 'wapuugotchi_quest_filter', array( QuestDate::class, 'add_wapuugotchi_filter' ), 10, 1 );
		\add_filter( 'wapuugotchi_quest_filter', array( QuestStart::class, 'add_wapuugotchi_filter' ), 1, 1 );
	}
}
