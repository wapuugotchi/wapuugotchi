<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Hunt;

use Wapuugotchi\Hunt\Handler\HuntHandler;

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
			'/hunt/start_mission',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'start_mission' ),
				'permission_callback' => array( self::class, 'has_start_mission_permission' ),
			)
		);
	}

	/**
	 * Permissions check.
	 *
	 * @return bool
	 */
	public static function has_start_mission_permission() {
		return \is_user_logged_in();
	}

	public static function start_mission( $req ) {
		$body = \json_decode( $req->get_body() );

		if ( ! isset( $body->id ) ) {
			return rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'id not set' ), 400 )
			);
		}

		if ( ! isset( $body->nonce ) ) {
			return rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'nonce not set' ), 400 )
			);
		}

		if ( ! \wp_verify_nonce( $body->nonce, 'wapuugotchi_hunt' ) ) {
			return rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'nonce not valid' ), 400 )
			);
		}

		$current_hunt = HuntHandler::get_current_hunt();
		$current_hunt['started'] = true;
		\update_user_meta( \get_current_user_id(), HuntHandler::CURRENT_HUNT_CONFIG, $current_hunt );

		return rest_ensure_response(
			new \WP_REST_Response( array( 'status' => '200' ), 200 )
		);
	}
}
