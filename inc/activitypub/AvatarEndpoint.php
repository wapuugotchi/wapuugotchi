<?php
/**
 * REST endpoint for serving Wapuu avatar SVGs.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\ActivityPub;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class AvatarEndpoint
 *
 * Provides a public REST endpoint for serving Wapuu avatar images.
 */
class AvatarEndpoint {

	/**
	 * The rest base path.
	 */
	const REST_BASE = 'wapuugotchi/v1';

	/**
	 * Register the REST route.
	 *
	 * @return void
	 */
	public static function register_routes() {
		\register_rest_route(
			self::REST_BASE,
			'/avatar/(?P<user_id>\d+)',
			array(
				'methods'             => 'GET',
				'callback'            => array( self::class, 'get_avatar' ),
				'permission_callback' => '__return_true',
				'args'                => array(
					'user_id' => array(
						'required'          => true,
						'validate_callback' => function ( $param ) {
							return is_numeric( $param );
						},
					),
				),
			)
		);
	}

	/**
	 * Serve the Wapuu avatar SVG.
	 *
	 * @param \WP_REST_Request $request The request object.
	 *
	 * @return \WP_REST_Response|\WP_Error The response.
	 */
	public static function get_avatar( $request ) {
		$user_id = (int) $request->get_param( 'user_id' );
		$user    = \get_user_by( 'id', $user_id );

		if ( ! $user ) {
			return new \WP_Error(
				'wapuugotchi_user_not_found',
				\__( 'User not found', 'wapuugotchi' ),
				array( 'status' => 404 )
			);
		}

		$svg = \get_user_meta( $user_id, 'wapuugotchi_shop_svg', true );

		if ( empty( $svg ) ) {
			return new \WP_Error(
				'wapuugotchi_avatar_not_found',
				\__( 'Avatar not found', 'wapuugotchi' ),
				array( 'status' => 404 )
			);
		}

		$response = new \WP_REST_Response( null, 200 );

		// Send the SVG directly with proper headers.
		header( 'Content-Type: image/svg+xml; charset=utf-8' );
		header( 'Cache-Control: public, max-age=3600' );
		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo $svg;
		exit;
	}

	/**
	 * Get the avatar URL for a given user.
	 *
	 * @param int $user_id The WordPress user ID.
	 *
	 * @return string The avatar URL.
	 */
	public static function get_avatar_url( $user_id ) {
		return \rest_url( self::REST_BASE . '/avatar/' . $user_id );
	}
}
