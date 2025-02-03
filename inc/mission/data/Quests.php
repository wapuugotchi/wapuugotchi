<?php
/**
 * The QuestDate Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission\Data;

use Wapuugotchi\Mission\Handler\MissionHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestDate
 */
class Quests {
	/**
	 * Get true.
	 *
	 * @return true
	 */
	public static function always_true() {
		return true;
	}

	/**
	 * Get true.
	 *
	 * @return bool
	 */
	public static function completed() {
		$user_data = MissionHandler::get_user_data();
		if ( empty( $user_data ) || empty( $user_data['actions'] ) || empty( $user_data['progress'] ) ) {
			return false;
		}

		return count( $user_data['actions'] ) === $user_data['progress'];
	}

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public static function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Quest\Models\Quest( 'complete_first_mission', null, __( 'Finish your first mission', 'wapuugotchi' ), __( 'Congrats on completing your first mission! &#128170;', 'wapuugotchi' ), 'success', 100, 5, 'Wapuugotchi\Mission\Data\Quests::always_true', 'Wapuugotchi\Mission\Data\Quests::completed' ),
		);

		return array_merge( $default_quest, $quests );
	}
}
