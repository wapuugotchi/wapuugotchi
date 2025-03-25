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
				'callback'            => array( self::class, 'handle_mission' ),
				'permission_callback' => array( self::class, 'has_permission' ),
			)
		);
		\register_rest_route(
			self::REST_BASE,
			'/hunt/complete_mission',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'handle_mission' ),
				'permission_callback' => array( self::class, 'has_permission' ),
			)
		);
		\register_rest_route(
			self::REST_BASE,
			'/hunt/delete_mission',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'handle_mission' ),
				'permission_callback' => array( self::class, 'has_permission' ),
			)
		);
	}

	/**
	 * Permissions check.
	 *
	 * @return bool
	 */
	public static function has_permission() {
		return \is_user_logged_in();
	}

	/**
	 * Handle mission start and completion.
	 *
	 * @param \WP_REST_Request $req The request object.
	 * @return \WP_REST_Response
	 */
	public static function handle_mission( $req ) {
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

		switch ( $req->get_route() ) {
			case '/' . self::REST_BASE . '/hunt/start_mission':
				$current_hunt['state'] = 'started';
				break;
			case '/' . self::REST_BASE . '/hunt/complete_mission':
				$current_hunt['state'] = 'completed';
				break;
			case '/' . self::REST_BASE . '/hunt/bill_mission':
				$current_hunt['state'] = 'billed';
				break;
			default:
				return rest_ensure_response(
					new \WP_REST_Response(
						array(
							'error' => 'invalid route',
							'route' => $req->get_route(),
						),
						400
					)
				);
		}

		\update_user_meta( \get_current_user_id(), HuntHandler::CURRENT_HUNT_CONFIG, $current_hunt );

		return rest_ensure_response(
			new \WP_REST_Response( array( 'status' => '200' ), 200 )
		);
	}
}
