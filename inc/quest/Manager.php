<?php
/**
 * The Log Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest;

use Wapuugotchi\Quest\Handler\QuestHandler;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Log
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_action( 'admin_init', array( $this, 'manage_quest_completion' ), 1000, 0 );
		\add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
	}

	/**
	 * Initialization Manager
	 *
	 * @param string $hook_suffix The internal page name.
	 *
	 * @return void
	 */
	public function init( $hook_suffix ) {
		if ( 'wapuugotchi_page_wapuugotchi__quests' === $hook_suffix ) {
			$this->load_scripts();
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 */
	public function load_scripts() {
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
	 * Manage Quest Completion
	 *
	 * @return void
	 */
	public function manage_quest_completion() {
		QuestHandler::manage_quest_progress();
	}
}
