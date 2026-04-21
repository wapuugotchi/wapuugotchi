<?php
/**
 * The PwnedMessage Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security\Data;

use Wapuugotchi\Avatar\Models\Message;
use Wapuugotchi\Security\Handler\MessageHandler;
use Wapuugotchi\Security\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Builds the HaveIBeenPwned warning bubble message.
 */
class PwnedMessage {

	/**
	 * Unique message identifier used for dismissal tracking.
	 */
	const MESSAGE_ID = 'security-pwned';

	/**
	 * Add a pwned-password warning to the bubble if the last HIBP check flagged the user.
	 *
	 * @param array $messages Existing messages.
	 *
	 * @return array
	 */
	public static function add_pwned_message_filter( $messages ) {
		if ( ! \current_user_can( 'update_plugins' ) ) {
			return $messages;
		}

		$user_id = \get_current_user_id();
		if ( ! $user_id ) {
			return $messages;
		}

		if ( ! \get_user_meta( $user_id, Meta::PWNED_RESULT_META_KEY, true ) ) {
			return $messages;
		}

		$message_id = self::MESSAGE_ID;

		if ( ! MessageHandler::is_active( $message_id ) ) {
			return $messages;
		}

		$messages[] = new Message(
			$message_id,
			self::get_random_warning(),
			'security-critical',
			'__return_true',
			'Wapuugotchi\Security\Handler\MessageHandler::handle_submit'
		);

		return $messages;
	}

	/**
	 * Return one of four random warning messages.
	 *
	 * @return string
	 */
	private static function get_random_warning() {
		$warnings = array(
			\__( '<strong>⚠ We have a problem!</strong> Our password has shown up in a public data breach — attackers may already have it. We need to change it immediately!', 'wapuugotchi' ),
			\__( '<strong>⚠ We are in danger!</strong> Our password is on a known list of stolen credentials. The bad guys could use it to break into our account — we have to act right now!', 'wapuugotchi' ),
			\__( '<strong>⚠ We need to act!</strong> Our password was leaked in a data breach. Anyone with that list is able to attack us — let\'s change it today before it\'s too late!', 'wapuugotchi' ),
			\__( '<strong>⚠ This is serious!</strong> Our password was found in a breach database. Attackers are out there and could use it against us — we must update it immediately!', 'wapuugotchi' ),
		);

		return $warnings[ \array_rand( $warnings ) ];
	}
}
