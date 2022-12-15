<?php
namespace Ionos\Wapuugotchi;

if( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Api {
    public function __construct() {
	    add_action( 'rest_api_init', [ $this, 'create_rest_routes' ] );
	}

	public function create_rest_routes() {
		register_rest_route( 'wapuugotchi/v1', '/wapuu', [
			'methods' => 'GET',
			'callback' => [ $this, 'get_settings' ],
			'permission_callback' => [ $this, 'has_get_settings_permission' ]
		] );

		register_rest_route( 'wapuugotchi/v1', '/wapuu', [
			'methods' => 'POST',
			'callback' => [ $this, 'set_settings' ],
			'permission_callback' => [ $this, 'has_set_settings_permission' ]
		] );
	}

	public function has_get_settings_permission() {
		return true;
	}

	public function has_set_settings_permission() {
		return current_user_can( 'publish_posts' );
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
}