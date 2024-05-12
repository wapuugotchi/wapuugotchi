<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class MessageHandler
 */
class MessageHandler {
	/**
	 * Set message submitted.
	 *
	 * @param int $quest_id The ID of the quest.
	 *
	 * @return bool
	 */
	public static function set_message_submitted( $quest_id ) {
		$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_quest_completed', true );
		if ( empty( $completed_quests ) ) {
			return false;
		}

		if ( ! isset( $completed_quests[ $quest_id ] ) ) {
			return false;
		}

		$completed_quests[ $quest_id ]['notified'] = true;
		update_user_meta( get_current_user_id(), 'wapuugotchi_quest_completed', $completed_quests );

		return true;
	}

	/**
	 * Is active.
	 *
	 * @return bool
	 */
	public static function is_active() {
		return true;
	}
}
