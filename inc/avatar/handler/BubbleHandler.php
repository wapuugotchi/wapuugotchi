<?php
/**
 * The Avatar Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar\Handler;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Manager
 */
class BubbleHandler {
	public static function get_all_messages() {
		return \apply_filters( 'wapuugotchi_speech_bubble', array() );
	}

	public static function get_active_messages() {
		return self::get_message_by_is_active( true );
	}

	public static function get_inactive_messages() {
		return self::get_message_by_is_active( false );
	}

	public static function get_message_by_id($id) {
		$messages = self::get_all_messages();

		foreach ($messages as $message) {
			if ($message->get_id() === $id) {
				return $message;
			}
		}

		return null;
	}

	/**
	 * Get all messages by the state.
	 *
	 * @param bool $state The state of the message.
	 *
	 * @return array
	 */
	private static function get_message_by_is_active( bool $state ) {
		$messages = self::get_all_messages();

		$filtered_messages = \array_filter($messages, function($message) use ($state) {
			return $message->is_active() === $state;
		});

		return array_map(function($message) {
			return array(
				'id'      => $message->get_id(),
				'message' => $message->get_message(),
				'type'  => $message->get_type()
			);
		}, $filtered_messages);
	}
}
