<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Filters;

use Wapuugotchi\Avatar\Models\Message;
use Wapuugotchi\Quest\Handler\MessageHandler;
use Wapuugotchi\Quest\Handler\QuestHandler;
use Wapuugotchi\Quest\Models\Quest;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class MessageManager
 */
class MessageManager {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_speech_bubble', array( $this, 'add_wapuugotchi_messages' ) );
	}

	/**
	 * Get true.
	 *
	 * @return bool
	 */
	public static function is_active() {
		return true;
	}

	/**
	 * Get true.
	 *
	 * @param int $id The ID of the message.
	 *
	 * @return bool
	 */
	public static function handle_submit( $id ) {
		return MessageHandler::set_message_submitted( $id );
	}

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $messages The messages.
	 *
	 * @return array|Quest[]
	 */
	public function add_wapuugotchi_messages( $messages ) {

		$completed_quests = QuestHandler::get_completed_quests();
		if ( empty( $completed_quests ) ) {
			return false;
		}

		foreach ( $completed_quests as $id => $completed_quest ) {
			if ( ! isset( $completed_quest['notified'] ) ) {
				continue;
			}

			if ( false !== $completed_quest['notified'] ) {
				continue;
			}

			$quest = QuestHandler::get_quest_by_id( $id );
			if ( ! $quest instanceof Quest ) {
				continue;
			}

			$new_message = array(
				new Message( $quest->get_id(), $quest->get_message(), 'info', 'Wapuugotchi\Quest\Filters\MessageManager::is_active', 'Wapuugotchi\Quest\Filters\MessageManager::handle_submit' ),
			);

			$messages = array_merge( $new_message, $messages );
		}

		return $messages;
	}
}
