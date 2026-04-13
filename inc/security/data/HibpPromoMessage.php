<?php
/**
 * The HibpPromoMessage Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security\Data;

use Wapuugotchi\Avatar\Models\Message;
use Wapuugotchi\Security\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Promotes the HIBP password breach check feature to users who have not enabled it yet.
 */
class HibpPromoMessage {

	/**
	 * Unique message identifier.
	 */
	const MESSAGE_ID = 'security-hibp-promo';

	/**
	 * Add the HIBP promo message to the bubble if not yet permanently dismissed.
	 *
	 * @param array $messages Existing messages.
	 *
	 * @return array
	 */
	public static function add_hibp_promo_filter( $messages ) {
		if ( ! \current_user_can( 'update_plugins' ) ) {
			return $messages;
		}

		$user_id = \get_current_user_id();
		if ( ! $user_id ) {
			return $messages;
		}

		if ( \get_user_meta( $user_id, Meta::HIBP_PROMO_DISMISSED_META_KEY, true ) ) {
			return $messages;
		}

		$message_id = self::MESSAGE_ID;

		$messages[] = new Message(
			$message_id,
			self::get_promo_message(),
			'info',
			function () use ( $user_id ) {
				return ! \get_user_meta( $user_id, Meta::HIBP_PROMO_DISMISSED_META_KEY, true );
			},
			function () use ( $user_id ) {
				return (bool) \update_user_meta( $user_id, Meta::HIBP_PROMO_DISMISSED_META_KEY, true );
			}
		);

		return $messages;
	}

	/**
	 * Return the promo message text.
	 *
	 * @return string
	 */
	private static function get_promo_message() {
		return \__( 'Is your password safe? I can check! Just activate the <strong>Password Breach Check</strong> in the Wapuugotchi Settings — I\'ll warn you if hackers already have it.', 'wapuugotchi' );
	}
}
