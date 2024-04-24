<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar;

use Wapuugotchi\Avatar\Handler\BubbleHandler;
use WP_HTTP_Response;
use function add_action;
use function call_user_func;
use function is_callable;
use function is_user_logged_in;
use function json_decode;
use function register_rest_route;
use function rest_ensure_response;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Api
 */
class Api {

	/**
	 * The rest base path to the WapuuGotchi api.
	 */
	const REST_BASE = 'wapuugotchi/v1';

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_action( 'rest_api_init', array( $this, 'create_rest_routes' ) );
	}

	/**
	 * Register all API endpoints.
	 *
	 * @return void
	 */
	public function create_rest_routes() {
		register_rest_route(
			self::REST_BASE,
			'/submit_message',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'submit_message' ),
				'permission_callback' => array( $this, 'has_get_message_permission' ),
			)
		);
	}

	/**
	 * Permissions check.
	 *
	 * @return bool
	 */
	public function has_get_message_permission() {
		return is_user_logged_in();
	}

	/**
	 * Delete the last read message.
	 *
	 * @param WP_REST_Request $req Contains the last read message.
	 *
	 * @return WP_Error|WP_HTTP_Response|WP_REST_Response
	 */
	public function submit_message( $req ) {
		$body   = json_decode( $req->get_body() );
		$result = false;

		if ( null !== $body->id ) {
			$message = BubbleHandler::get_message_by_id( $body->id );
			if ( $message && is_callable( $message->handle_submit() ) ) {
				$result = call_user_func( $message->handle_submit(), $body->id );
			}
		}

		return rest_ensure_response( array( 'state' => $result ) );
	}
}
