<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

use http\Env\Request;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

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
			'/wapuu',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_settings' ),
				'permission_callback' => '__return_true',
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/wapuu',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'set_settings' ),
				'permission_callback' => array( $this, 'has_set_settings_permission' ),
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/message',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'remove_message' ),
				'permission_callback' => array( $this, 'has_get_message_permission' ),
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/credits',
			array(
				'methods'             => 'GET',
				'callback'            => array( $this, 'get_balance' ),
				'permission_callback' => 'is_user_logged_in',
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/credits',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_balance' ),
				'permission_callback' => 'is_user_logged_in',
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/wearable',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'unlock_wearable' ),
				'permission_callback' => 'is_user_logged_in',
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/purchases',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'update_purchases' ),
				'permission_callback' => 'is_user_logged_in',
			)
		);
	}


	/**
	 * Permissions check.
	 *
	 * @return bool
	 */
	public function has_set_settings_permission() {
		return current_user_can( 'publish_posts' );
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
	 * Set new WapuuGotchi configuration of the currently worn items.
	 *
	 * @param WP_REST_Request $req Config current Wapuu configuration.
	 *
	 * @return WP_Error|\WP_HTTP_Response|WP_REST_Response
	 */
	public function set_settings( $req ) {
		$check = false;
		if ( ! empty( $req['wapuu'] ) ) {
			update_user_meta( get_current_user_id(), 'wapuugotchi__alpha', wp_json_encode( $req['wapuu'] ) );
			$check = true;
		}

		return rest_ensure_response( $check );
	}

	/**
	 * Get the default worn items.
	 *
	 * @return WP_Error|\WP_HTTP_Response|WP_REST_Response
	 */
	public function get_settings() {
		return rest_ensure_response( json_decode( file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/default.json' ) ) );
	}

	/**
	 * Delete the last read message.
	 *
	 * @param WP_REST_Request $req Contains the last read message.
	 *
	 * @return WP_Error|\WP_HTTP_Response|WP_REST_Response
	 */
	public function remove_message( $req ) {
		$body  = json_decode( $req->get_body() );
		$state = false;

		if ( null !== $body->remove_message ) {
			if ( 'notification' === $body->remove_message->category ) {
				$active_notifications    = NotificationManager::get_active_quests();
				$confirmed_notifications = get_user_meta( get_current_user_id(), 'wapuugotchi_confirmed_notifications__alpha', true );
				foreach ( $active_notifications as $active_notification ) {
					if ( $active_notification['id'] === $body->remove_message->id ) {
						$confirmed_notifications[ $active_notification['id'] ] = array(
							'id'       => $active_notification['id'],
							'remember' => $active_notification['remember'],
						);
					}
				}

				update_user_meta(
					get_current_user_id(),
					'wapuugotchi_confirmed_notifications__alpha',
					$confirmed_notifications
				);
			} elseif ( 'quest' === $body->remove_message->category ) {
				$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true );
				if ( isset( $completed_quests[ $body->remove_message->id ] ) ) {
					$completed_quests[ $body->remove_message->id ]['notified'] = true;
					update_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', $completed_quests );
					$state = true;
				}
			}
		}

		return rest_ensure_response( array( 'state' => $state ) );
	}

	/**
	 * Get current pear balance.
	 *
	 * @return WP_Error|\WP_HTTP_Response|WP_REST_Response
	 */
	public function get_balance() {
		$balance = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ) );

		return rest_ensure_response( array( 'balance' => $balance ) );
	}

	/**
	 * Update pearl balance.
	 *
	 * @param WP_REST_Request $req Contains the amount of money to be added.
	 *
	 * @return WP_Error|\WP_HTTP_Response|WP_REST_Response
	 */
	public function update_balance( $req ) {
		$balance = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ) );
		$body    = json_decode( $req->get_body() );
		$amount  = $body->amount;
		if ( gettype( $amount ) !== 'integer' ) {
			return rest_ensure_response( new WP_Error( 'provide amount as integer' ) );
		}
		$balance = $balance + $amount;
		if ( $balance < 0 ) {
			return rest_ensure_response( new WP_Error( __( 'Insufficent balance' ) ) );
		}
		update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', $balance );

		return rest_ensure_response( array( 'balance' => $balance ) );
	}

	/**
	 * Unlock an item so that it can be worn from that moment on.
	 *
	 * @param WP_REST_Request $request Contains the item which should be unlocked.
	 *
	 * @return WP_Error|\WP_HTTP_Response|WP_REST_Response
	 */
	public function unlock_wearable( WP_REST_Request $request ) {
		$balance = get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true );
		$params  = $request->get_json_params();

		if ( ! isset( $params['uuid'] ) ) {
			return rest_ensure_response( new WP_Error( 'missing_uuid', __( 'Missing UUID.' ), array( 'status' => 400 ) ) );
		}

		$unlocked_items = get_user_meta( get_current_user_id(), 'wapuugotchi_unlocked_items__alpha', true );

		if ( in_array( $params['uuid'], $unlocked_items, true ) ) {
			return rest_ensure_response( new WP_Error( 'already_unlocked', __( 'Item already unlocked.' ), array( 'status' => 400 ) ) );
		}

		$balance           = get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true );
		$wapuugotchi_items = get_transient( 'wapuugotchi_items' );

		$item = null;
		foreach ( $wapuugotchi_items as $key => $items ) {
			if ( isset( $items[ $params['uuid'] ] ) ) {
				$item = $items[ $params['uuid'] ];
			}
		}
		if ( null === $item ) {
			return rest_ensure_response( new WP_Error( 'invalid_uuid', __( 'Item does not exist.' ), array( 'status' => 400 ) ) );
		}

		if ( $balance < $item->meta->price ) {
			return rest_ensure_response( new WP_Error( 'insufficient_balance', __( 'Insufficient balance.' ), array( 'status' => 400 ) ) );
		}

		$balance = $balance - $item->meta->price;
		update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', $balance );
		$unlocked_items[] = $params['uuid'];
		update_user_meta( get_current_user_id(), 'wapuugotchi_unlocked_items__alpha', $unlocked_items );

		return rest_ensure_response( new WP_REST_Response( array( 'status' => 'Item was unlocked successfully' ), 200 ) );
	}

	/**
	 * Start item payment process.
	 *
	 * @param WP_REST_Request $req Object.
	 *
	 * @return WP_Error|\WP_HTTP_Response|WP_REST_Response
	 */
	public function update_purchases( $req ) {
		$bought    = false;
		$purchases = get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true );
		$balance   = bcsub( get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ), $req['item']['price'] );
		if ( ! in_array( $req['item']['key'], $purchases, true ) && $balance >= 0 ) {
			$purchases[] = $req['item']['key'];
			update_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', $purchases );
			update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', $balance );

			$bought = true;
		}

		return rest_ensure_response( $bought );

	}
}
