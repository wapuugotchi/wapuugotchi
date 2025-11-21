<?php
/**
 * Contains classes and methods for the WapuuGotchi shop API.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop;

use Wapuugotchi\Shop\Handler\AvatarHandler;
use Wapuugotchi\Shop\Handler\BalanceHandler;
use Wapuugotchi\Shop\Handler\ItemHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Registers the WapuuGotchi shop endpoints and provides the necessary methods.
 */
class Api {

	/**
	 * The rest base path to the WapuuGotchi api.
	 */
	const REST_BASE = 'wapuugotchi/v1';

	/**
	 * Register all API endpoints.
	 *
	 * @return void
	 */
	public static function create_rest_routes() {
		register_rest_route(
			self::REST_BASE,
			'/wapuugotchi/balance/raise_balance',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'raise_balance' ),
				'permission_callback' => 'is_user_logged_in',
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/wapuugotchi/shop/unlock-item',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'update_purchases' ),
				'permission_callback' => 'is_user_logged_in',
			)
		);

		register_rest_route(
			self::REST_BASE,
			'/wapuugotchi/shop/update-avatar',
			array(
				'methods'             => 'POST',
				'callback'            => array( self::class, 'update_avatar' ),
				'permission_callback' => 'is_user_logged_in',
			)
		);
	}

	/**
	 * Update the purchases.
	 *
	 * @param \WP_REST_Request $req The request.
	 *
	 * @throws \Exception If the item could not be unlocked.
	 */
	public static function update_purchases( $req ) {

		if ( ! isset( $req['item'] ) || ! isset( $req['item']['key'], $req['item']['category'] ) ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '400',
						'message' => 'missing parameters',
					),
					400
				)
			);
		}

		// Sanitize and validate item key and category.
		$item_key      = \sanitize_text_field( $req['item']['key'] );
		$item_category = \sanitize_text_field( $req['item']['category'] );

		// Validate format (alphanumeric, underscore, hyphen only).
		if ( ! preg_match( '/^[a-zA-Z0-9_-]+$/', $item_key ) || ! preg_match( '/^[a-zA-Z0-9_-]+$/', $item_category ) ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '400',
						'message' => 'Invalid item key or category format',
					),
					400
				)
			);
		}

		$item = ItemHandler::get_items_by_id( $item_key, $item_category );
		if ( ! $item ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '404',
						'message' => 'Item not found',
					),
					404
				)
			);
		}

		$is_item_unlocked = ItemHandler::is_item_unlocked( $item_key );
		if ( $is_item_unlocked ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '404',
						'message' => 'Item already unlocked',
					),
					404
				)
			);
		}

		$payed = BalanceHandler::decrease_balance( $item );
		if ( ! $payed ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '404',
						'message' => 'Not enough balance',
					),
					404
				)
			);
		}

		$unlock_item = ItemHandler::unlock_item( $item_key );
		if ( ! $unlock_item ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '404',
						'message' => 'Item could not be unlocked',
					),
					404
				)
			);
		}

		return rest_ensure_response(
			new \WP_REST_Response(
				array(
					'status'  => '200',
					'message' => 'Item successfully updated',
				),
				200
			)
		);
	}

	/**
	 * Update the avatar.
	 *
	 * @param \WP_REST_Request $req The request.
	 *
	 * @return \WP_REST_Response
	 */
	public static function update_avatar( $req ) {
		// Validate avatar configuration is an array.
		if ( ! isset( $req['avatar'] ) || ! is_array( $req['avatar'] ) ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '400',
						'message' => 'Invalid avatar configuration',
					),
					400
				)
			);
		}

		// Validate SVG is a string and not too large (max 1MB).
		if ( ! isset( $req['svg'] ) || ! is_string( $req['svg'] ) ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '400',
						'message' => 'Invalid SVG data',
					),
					400
				)
			);
		}

		// Check SVG size limit (1MB = 1048576 bytes).
		if ( strlen( $req['svg'] ) > 1048576 ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '413',
						'message' => 'SVG data too large (max 1MB)',
					),
					413
				)
			);
		}

		// Validate SVG structure (must start with < and contain svg).
		$svg_trimmed = trim( $req['svg'] );
		if ( strpos( $svg_trimmed, '<' ) !== 0 || strpos( $svg_trimmed, 'svg' ) === false ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '400',
						'message' => 'Invalid SVG format',
					),
					400
				)
			);
		}

		AvatarHandler::update_avatar_config( $req['avatar'] );
		AvatarHandler::update_avatar_svg( $req['svg'] );

		return rest_ensure_response(
			new \WP_REST_Response(
				array(
					'status'  => '200',
					'message' => 'Avatar successfully updated',
				)
			)
		);
	}

	/**
	 * Raise the Balance.
	 *
	 * @param \WP_REST_Request $req The request.
	 *
	 * @return \WP_REST_Response
	 */
	public static function raise_balance( $req ) {
		$body = json_decode( $req->get_body() );

		if ( ! isset( $body->nonce ) || ! isset( $body->reward ) ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '404',
						'message' => 'missing parameters',
					),
					404
				)
			);
		}

		if ( ! wp_verify_nonce( $body->nonce, 'wapuugotchi_balance' ) ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '403',
						'message' => 'nonce not valid',
					),
					403
				)
			);
		}

		// Validate reward is a positive integer and within reasonable limits.
		$reward = intval( $body->reward );
		if ( $reward <= 0 || $reward > 10000 ) {
			return rest_ensure_response(
				new \WP_REST_Response(
					array(
						'status'  => '400',
						'message' => 'Invalid reward amount (must be 1-10000)',
					),
					400
				)
			);
		}

		BalanceHandler::increase_balance( $reward );

		return rest_ensure_response(
			new \WP_REST_Response(
				array(
					'status'  => '200',
					'message' => 'Balance successfully updated',

				)
			)
		);
	}
}
