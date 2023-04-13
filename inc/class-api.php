<?php
namespace Wapuugotchi\Wapuugotchi;

use WP_Error;
use WP_REST_Request;
use WP_REST_Response;

if( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Api {
	const REST_BASE = 'wapuugotchi/v1';

	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'create_rest_routes' ] );
	}

	public function create_rest_routes() {
		register_rest_route( self::REST_BASE, '/wapuu', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_settings' ],
			'permission_callback' => '__return_true'
		] );

		register_rest_route( self::REST_BASE, '/wapuu', [
			'methods' => 'POST',
			'callback' => [ $this, 'set_settings' ],
			'permission_callback' => [ $this, 'has_set_settings_permission' ]
		] );

		register_rest_route( self::REST_BASE, '/message', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_messages' ],
			'permission_callback' => [ $this, 'has_get_message_permission' ]
		] );

		register_rest_route( self::REST_BASE, '/credits', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_balance' ],
			'permission_callback' => 'is_user_logged_in'
		] );

		register_rest_route( self::REST_BASE, '/credits', [
			'methods' => 'POST',
			'callback' => [ $this, 'update_balance' ],
			'permission_callback' => 'is_user_logged_in'
		] );

		register_rest_route( self::REST_BASE, '/wearable', [
			'methods' => 'POST',
			'callback' => [ $this, 'unlock_wearable' ],
			'permission_callback' => 'is_user_logged_in'
		] );
	}


	public function has_set_settings_permission() {
		return current_user_can( 'publish_posts' );
	}

	public function has_get_message_permission() {
		return is_user_logged_in();
	}

	public function set_settings( $req ) {
		$check = true;
		if ( empty( $req['wapuu']) || empty( $req['svg']) ) {
			$check = false;
		} else {
			update_user_meta( get_current_user_id(), 'wapuugotchi_config', json_encode( $req['wapuu']));
			update_user_meta( get_current_user_id(), 'wapuugotchi_svg', json_encode( $req['svg']));

		}
		return rest_ensure_response( $check );
	}

	public function get_settings() {
		return rest_ensure_response( json_decode( file_get_contents(\plugin_dir_path( __DIR__ ) . 'config/default.json') ) );
	}

	public function get_messages() {
		return rest_ensure_response( [['message'=> 'dummy message #1'],['message'=> 'dummy message #2']]);
	}

	public function get_balance() {
		$balance = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi_balance', true ) );
		return rest_ensure_response( ['balance' => $balance]);
	}

	public function update_balance( $req ) {
		$balance = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi_balance', true ) );
		$body = json_decode($req->get_body());
		$amount =  $body->amount;
		if (gettype($amount) !== 'integer') {
			return rest_ensure_response( new WP_Error('provide amount as integer'));
		}
		$balance = $balance + $amount;
		if ( $balance < 0) {
			return rest_ensure_response( new WP_Error(__('Insufficent balance')));
		}
		update_user_meta( get_current_user_id(), 'wapuugotchi_balance', $balance);
		return rest_ensure_response( ['balance' => $balance] );
	}

	public function unlock_wearable( WP_REST_Request $request ) {
		return rest_ensure_response( new WP_REST_Response( [ 'status' => 'mops' ], 200 ) );
		$balance = get_user_meta( get_current_user_id(), 'wapuugotchi_balance', true );
		$params = $request->get_json_params();

		if ( ! isset( $params['uuid'] ) ) {
			return rest_ensure_response( new WP_Error( 'missing_uuid', __( 'Missing UUID.' ), [ 'status' => 400 ] ) );
		}

		$unlocked_items = get_user_meta( get_current_user_id(), 'wapuugotchi_unlocked_items', true );

		if ( in_array( $params['uuid'], $unlocked_items ) ) {
			return rest_ensure_response( new WP_Error( 'already_unlocked', __( 'Item already unlocked.' ), [ 'status' => 400 ] ) );
		}

		$balance = get_user_meta( get_current_user_id(), 'wapuugotchi_balance', true );
		$wapuugotchi_items = get_transient( 'wapuugotchi_items' );

		$item = null;
		foreach( $wapuugotchi_items as $key => $items ) {
			if ( isset( $items[ $params['uuid'] ] ) ) {
				$item = $items[ $params['uuid'] ];
			}
		}
		if ( $item === null ) {
			return rest_ensure_response( new WP_Error( 'invalid_uuid', __( 'Item does not exist.' ), [ 'status' => 400 ] ) );
		}

		if ( $balance < $item->meta->price ) {
			return rest_ensure_response( new WP_Error( 'insufficient_balance', __( 'Insufficient balance.' ), [ 'status' => 400 ] ) );
		}

		$balance = $balance - $item->meta->price;
		update_user_meta( get_current_user_id(), 'wapuugotchi_balance', $balance );
		$unlocked_items[] = $params['uuid'];
		update_user_meta( get_current_user_id(), 'wapuugotchi_unlocked_items', $unlocked_items );

		return rest_ensure_response( new WP_REST_Response( [ 'status' => 'Item was unlocked successfully' ], 200 ) );
	}
}
