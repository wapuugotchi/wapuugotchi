<?php
/**
 * ActivityPub integration manager.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\ActivityPub;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 *
 * Manages the ActivityPub integration for WapuuGotchi.
 */
class Manager {

	/**
	 * Constructor.
	 */
	public function __construct() {
		// Resolve Wapuu actors by username (e.g. wapuu-admin).
		\add_filter( 'activitypub_pre_get_by_username', array( self::class, 'get_by_username' ), 10, 2 );

		// Resolve Wapuu actors by negative ID.
		\add_filter( 'activitypub_pre_get_by_id', array( self::class, 'get_by_id' ), 10, 2 );

		// Allow Wapuu actor IDs to pass the permission check.
		\add_filter( 'activitypub_user_can_activitypub', array( self::class, 'user_can_activitypub' ), 10, 2 );

		// Register the avatar REST endpoint.
		\add_action( 'rest_api_init', array( AvatarEndpoint::class, 'register_routes' ) );

		// Initialize the publisher.
		Publisher::init();
	}

	/**
	 * Resolve a Wapuu actor by username.
	 *
	 * @param mixed  $pre      The pre-existing value.
	 * @param string $username The username.
	 *
	 * @return mixed The Wapuu actor or the original value.
	 */
	public static function get_by_username( $pre, $username ) {
		if ( 0 !== \strpos( $username, 'wapuu-' ) ) {
			return $pre;
		}

		$wp_username = \substr( $username, 6 ); // Remove 'wapuu-' prefix.
		$user        = \get_user_by( 'login', $wp_username );

		if ( ! $user ) {
			return $pre;
		}

		return new Wapuu( $user->ID );
	}

	/**
	 * Resolve a Wapuu actor by negative ID.
	 *
	 * @param mixed $pre     The pre-existing value.
	 * @param int   $user_id The user ID.
	 *
	 * @return mixed The Wapuu actor or the original value.
	 */
	public static function get_by_id( $pre, $user_id ) {
		if ( ! Wapuu::is_wapuu_id( $user_id ) ) {
			return $pre;
		}

		$wp_user_id = Wapuu::wapuu_id_to_user_id( $user_id );
		$user       = \get_user_by( 'id', $wp_user_id );

		if ( ! $user ) {
			return $pre;
		}

		return new Wapuu( $wp_user_id );
	}

	/**
	 * Allow Wapuu actor IDs to use ActivityPub.
	 *
	 * @param bool $enabled Whether the user can use ActivityPub.
	 * @param int  $user_id The user ID.
	 *
	 * @return bool Whether the user can use ActivityPub.
	 */
	public static function user_can_activitypub( $enabled, $user_id ) {
		if ( Wapuu::is_wapuu_id( $user_id ) ) {
			return true;
		}

		return $enabled;
	}
}
