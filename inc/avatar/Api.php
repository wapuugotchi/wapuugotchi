<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar;

use Wapuugotchi\Avatar\Handler\BubbleHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Api
 */
class Api {

	/**
	 * The rest base path to the WapuuGotchi API.
	 */
	const REST_BASE = 'wapuugotchi/v1';

	/**
	 * Register all API endpoints.
	 *
	 * @return void
	 */
	public static function register_endpoints() {
		\register_rest_route(
			self::REST_BASE,
			'/dismiss_message',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'dismiss_message' ),
				'permission_callback' => array( self::class, 'has_dismiss_message_permission' ),
			)
		);
	}

	/**
	 * Permissions check.
	 *
	 * @return bool
	 */
	public static function has_dismiss_message_permission() {
		return \is_user_logged_in();
	}

	/**
	 * Delete the last read message.
	 *
	 * @param \WP_REST_Request $req Contains the last read message.
	 *
	 * @return \WP_Error|\WP_HTTP_Response|\WP_REST_Response
	 */
	public static function dismiss_message( $req ) {
		$id     = self::get_message_id_from_request_body( $req );
		$result = false;

		$message = BubbleHandler::get_message_by_id( $id );
		if ( $message && \is_callable( $message->dismiss() ) ) {
			$result = \call_user_func( $message->dismiss(), $id );
		}

		return \rest_ensure_response( array( 'state' => $result ) );
	}


	/**
	 * Get the message ID from the request body.
	 *
	 * @param \WP_REST_Request $req The request object.
	 *
	 * @return mixed
	 */
	private static function get_message_id_from_request_body( $req ) {
		$body = \json_decode( $req->get_body() );
		$id   = $body->id ?? null;
		if ( null === $id ) {
			return \rest_ensure_response( new \WP_Error( 'invalid_json', 'Invalid JSON body.', array( 'status' => 400 ) ) );
		}

		return $id;
	}
}
