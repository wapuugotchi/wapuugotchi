<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Handler;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

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
		$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_quest_completed__alpha', true );
		if ( empty( $completed_quests ) ) {
			return false;
		}

		if ( ! isset( $completed_quests[ $quest_id ] ) ) {
			return false;
		}

		$completed_quests[ $quest_id ]['notified'] = true;
		update_user_meta( get_current_user_id(), 'wapuugotchi_quest_completed__alpha', $completed_quests );

		return true;
	}


	/**
	 * Send message to avatar by creating a \Wapuugotchi\Avatar\Models\Message object.
	 *
	 * @return bool
	 */
	public static function send_message_to_avatar() {
		$message = class_exists( '\Wapuugotchi\Avatar\Models\Message' );
		if ( ! $message ) {
			return false;
		}

		$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_quest_completed__alpha', true );
		if ( empty( $completed_quests ) ) {
			return false;
		}

		foreach ( $completed_quests as $id => $completed_quest ) {
			if ( ! isset( $completed_quest['notified'] ) || true === $completed_quest['notified'] ) {
				continue;
			}

			$quest = QuestHandler::get_quest_by_id( $id );
			if ( ! $quest instanceof \Wapuugotchi\Quest\Models\Quest ) {
				continue;
			}

			new \Wapuugotchi\Avatar\Models\Message( $quest->get_id(), $quest->get_message(), $quest->get_type(), 'Wapuugotchi\Quest\Handler\MessageHandler::is__active', 'Wapuugotchi\Quest\Handler\MessageHandler::set_message_submitted' );
		}

		return true;
	}

	/**
	 * Is active.
	 *
	 * @return bool
	 */
	public static function is__active() {
		return true;
	}
}
