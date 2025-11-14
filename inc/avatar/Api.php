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
		$id = self::get_message_id_from_request_body( $req );

		// Handle error case from get_message_id_from_request_body.
		if ( $id instanceof \WP_Error || $id instanceof \WP_REST_Response ) {
			return $id;
		}

		// Sanitize the message ID to prevent injection attacks.
		$id = \sanitize_text_field( $id );

		// Validate that ID is alphanumeric with underscores/hyphens only.
		if ( ! preg_match( '/^[a-zA-Z0-9_-]+$/', $id ) ) {
			return \rest_ensure_response(
				new \WP_Error(
					'invalid_message_id',
					'Invalid message ID format.',
					array( 'status' => 400 )
				)
			);
		}

		$result  = false;
		$message = BubbleHandler::get_message_by_id( $id );

		// Verify message exists and has a valid dismiss callback.
		if ( $message ) {
			$dismiss_callback = $message->dismiss();

			// Only execute if callback is callable and from a trusted namespace.
			if ( \is_callable( $dismiss_callback ) ) {
				// Security check: Validate callback is from plugin namespace.
				if ( self::is_trusted_callback( $dismiss_callback ) ) {
					$result = \call_user_func( $dismiss_callback, $id );
				}
			}
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

	/**
	 * Validate that a callback comes from a trusted source (plugin namespace).
	 *
	 * This prevents arbitrary function execution from user-controlled filters.
	 *
	 * @param callable $callback The callback to validate.
	 *
	 * @return bool True if callback is trusted, false otherwise.
	 */
	private static function is_trusted_callback( $callback ) {
		// If callback is a string (function name), check it's not a dangerous function.
		if ( \is_string( $callback ) ) {
			// Blacklist dangerous functions.
			$dangerous_functions = array(
				'system',
				'exec',
				'passthru',
				'shell_exec',
				'eval',
				'assert',
				'create_function',
				'include',
				'include_once',
				'require',
				'require_once',
				'file_get_contents',
				'file_put_contents',
				'unlink',
			);

			if ( \in_array( strtolower( $callback ), $dangerous_functions, true ) ) {
				return false;
			}

			// Allow only callbacks from Wapuugotchi namespace or WordPress core.
			return strpos( $callback, 'Wapuugotchi\\' ) === 0 || strpos( $callback, 'wp_' ) === 0;
		}

		// If callback is an array [class, method], validate the class namespace.
		if ( \is_array( $callback ) && count( $callback ) === 2 ) {
			$class = $callback[0];

			// If it's an object, get its class name.
			if ( \is_object( $class ) ) {
				$class = \get_class( $class );
			}

			// Only allow callbacks from plugin namespace.
			if ( \is_string( $class ) ) {
				return strpos( $class, 'Wapuugotchi\\' ) === 0;
			}
		}

		// Reject closures and other callback types for security.
		return false;
	}
}
