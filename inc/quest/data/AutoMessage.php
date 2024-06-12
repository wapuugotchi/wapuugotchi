<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Data;

use Wapuugotchi\Quest\Handler\QuestHandler;
use Wapuugotchi\Quest\Models\Quest;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class AutoMessage
 */
class AutoMessage {

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $messages The messages.
	 *
	 * @return array|Quest[]
	 */
	public static function add_wapuugotchi_messages( $messages ) {
		$message = class_exists( '\Wapuugotchi\Avatar\Models\Message' );
		if ( ! $message ) {
			return $messages;
		}

		$completed_quests = \get_user_meta( \get_current_user_id(), 'wapuugotchi_quest_completed', true );
		if ( empty( $completed_quests ) ) {
			return $messages;
		}

		foreach ( $completed_quests as $id => $completed_quest ) {
			if ( ! isset( $completed_quest['notified'] ) || true === $completed_quest['notified'] ) {
				continue;
			}

			$quest = QuestHandler::get_quest_by_id( $id );
			if ( ! $quest instanceof Quest ) {
				continue;
			}

			$messages[] = new \Wapuugotchi\Avatar\Models\Message( $quest->get_id(), $quest->get_message(), $quest->get_type(), 'Wapuugotchi\Quest\Handler\MessageHandler::is_active', 'Wapuugotchi\Quest\Handler\MessageHandler::set_message_submitted' );
		}

		return $messages;
	}
}
