<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission;

use Wapuugotchi\Mission\Handler\ActionHandler;
use Wapuugotchi\Mission\Handler\MissionHandler;

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
	public static function create_rest_routes() {
		\register_rest_route(
			self::REST_BASE,
			'/mission/set_completed',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'set_completed' ),
				'permission_callback' => array( self::class, 'set_completed_permissions' ),
			)
		);
	}

	/**
	 * Permissions check.
	 *
	 * @return bool
	 */
	public static function set_completed_permissions() {
		return \is_user_logged_in();
	}

	/**
	 * Set the mission as completed.
	 *
	 * @param \WP_REST_Request $req The request object.
	 *
	 * @return \WP_REST_Response The response object.
	 * @throws \Exception If the nonce is not set or not valid.
	 */
	public static function set_completed( $req ) {
		$body = \json_decode( $req->get_body() );

		if ( ! isset( $body->nonce ) ) {
			return rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'nonce not set' ), 400 )
			);
		}

		if ( ! \wp_verify_nonce( $body->nonce, 'wapuugotchi_mission' ) ) {
			return rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'nonce not valid' ), 400 )
			);
		}

		$result = MissionHandler::raise_mission_step();
		if ( ! $result ) {
			return rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'could not raise mission step' ), 400 )
			);
		}
		return rest_ensure_response(
			new \WP_REST_Response( array( 'status' => '200' ), 200 )
		);
	}
}
