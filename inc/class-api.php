<?php
namespace Wapuugotchi\Wapuugotchi;

use WP_Error;

if( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Api {
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'create_rest_routes' ] );
	}

	public function create_rest_routes() {
		register_rest_route( 'wapuugotchi/v1', '/wapuu', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_settings' ],
			'permission_callback' => [ $this, '__return_true' ]
		] );

		register_rest_route( 'wapuugotchi/v1', '/wapuu', [
			'methods' => 'POST',
			'callback' => [ $this, 'set_settings' ],
			'permission_callback' => [ $this, 'has_set_settings_permission' ]
		] );

		register_rest_route( 'wapuugotchi/v1', '/message', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_messages' ],
			'permission_callback' => [ $this, 'has_get_message_permission' ]
		] );

		register_rest_route( 'wapuugotchi/v1', '/credits', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_balance' ],
			'permission_callback' => 'is_user_logged_in'
		] );

		register_rest_route( 'wapuugotchi/v1', '/credits', [
			'methods' => 'POST',
			'callback' => [ $this, 'update_balance' ],
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
		$check = false;
		if ( !empty( $req['wapuu']) ) {
			update_user_meta( get_current_user_id(), 'wapuugotchi', json_encode( $req['wapuu']));
			$check = true;
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
}
