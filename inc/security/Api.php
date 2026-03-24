<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Handles the remote vulnerability API.
 */
class Api {
	/**
	 * External API endpoint.
	 */
	const API_URL = 'https://vulnerability.wapuugotchi.com/api/vulns-batch';

	/**
	 * Query the remote vulnerability API.
	 *
	 * @param array $plugins Plugin payload.
	 *
	 * @return array
	 */
	public static function fetch_security_data( $plugins ) {
		$response = \wp_remote_post(
			self::API_URL,
			array(
				'timeout' => 20,
				'headers' => array( 'Content-Type' => 'application/json' ),
				'body'    => \wp_json_encode( $plugins ),
			)
		);

		if ( \is_wp_error( $response ) ) {
			return array(
				'error'   => true,
				'message' => $response->get_error_message(),
			);
		}

		return array(
			'status' => \wp_remote_retrieve_response_code( $response ),
			'body'   => \json_decode( \wp_remote_retrieve_body( $response ), true ),
		);
	}
}
