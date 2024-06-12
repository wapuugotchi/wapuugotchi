<?php
/**
 * The BubbleHandler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Handles all bubble related tasks.
 */
class BubbleHandler {
	/**
	 * Get all active messages.
	 *
	 * @return array
	 */
	public static function get_active_messages() {
		return self::get_message_by_is_active( true );
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

		if ( ! \is_array( $messages ) ) {
			return array();
		}

		$filtered_messages = \array_filter(
			$messages,
			function ( $message ) use ( $state ) {
				return $message->is_active() === $state;
			}
		);

		$result = array_map(
			function ( $message ) {
				return array(
					'id'      => $message->get_id(),
					'message' => $message->get_message(),
					'type'    => $message->get_type(),
				);
			},
			$filtered_messages
		);

		return array_values( $result );
	}

	/**
	 * Get all messages.
	 *
	 * @return array
	 */
	public static function get_all_messages() {
		return \apply_filters( 'wapuugotchi_bubble_messages', array() );
	}

	/**
	 * Get all inactive messages.
	 *
	 * @return array
	 */
	public static function get_inactive_messages() {
		return self::get_message_by_is_active( false );
	}

	/**
	 * Get a message by id.
	 *
	 * @param string $id The id of the message.
	 *
	 * @return Message|null
	 */
	public static function get_message_by_id( $id ) {
		$messages = self::get_all_messages();

		foreach ( $messages as $message ) {
			if ( $message->get_id() === $id ) {
				return $message;
			}
		}

		return null;
	}
}
