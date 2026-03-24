<?php
/**
 * The Message Handler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security\Handler;

use Wapuugotchi\Security\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Manages message state for security results.
 */
class MessageHandler {
	/**
	 * Map API severity to a bubble type.
	 *
	 * @param string $severity Severity from the vulnerability API.
	 *
	 * @return string
	 */
	public static function get_message_type_by_severity( $severity ) {
		$allowed_severities = array( 'critical', 'high', 'medium', 'low', 'none', 'unknown' );

		if ( ! \in_array( $severity, $allowed_severities, true ) ) {
			return 'security-unknown';
		}

		return 'security-' . $severity;
	}

	/**
	 * Check if a security message is active.
	 *
	 * @param string $message_id Message id.
	 *
	 * @return bool
	 */
	public static function is_active( $message_id = 'security-all-clear' ) {
		$user_id = \get_current_user_id();
		if ( ! $user_id ) {
			return false;
		}

		$meta  = \get_user_meta( $user_id, Meta::DISMISSED_META_KEY, true );
		$today = \wp_date( 'Y-m-d' );

		if ( ! \is_array( $meta ) || empty( $meta['date'] ) || $today !== $meta['date'] ) {
			return true;
		}

		$dismissed_ids = isset( $meta['ids'] ) && \is_array( $meta['ids'] ) ? $meta['ids'] : array();

		return ! \in_array( $message_id, $dismissed_ids, true );
	}

	/**
	 * Persist dismissal for a security message.
	 *
	 * @param string $message_id Message id.
	 *
	 * @return bool
	 */
	public static function handle_submit( $message_id ) {
		$user_id = \get_current_user_id();
		if ( ! $user_id ) {
			return false;
		}

		$today = \wp_date( 'Y-m-d' );
		$meta  = \get_user_meta( $user_id, Meta::DISMISSED_META_KEY, true );

		if ( ! \is_array( $meta ) || empty( $meta['date'] ) || $today !== $meta['date'] ) {
			$meta = array(
				'date' => $today,
				'ids'  => array(),
			);
		}

		if ( ! isset( $meta['ids'] ) || ! \is_array( $meta['ids'] ) ) {
			$meta['ids'] = array();
		}

		if ( ! \in_array( $message_id, $meta['ids'], true ) ) {
			$meta['ids'][] = $message_id;
		}

		return (bool) \update_user_meta( $user_id, Meta::DISMISSED_META_KEY, $meta );
	}
}
