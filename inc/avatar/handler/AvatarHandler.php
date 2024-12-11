<?php
/**
 * The AvatarHandler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Handles all avatar related tasks.
 */
class AvatarHandler {

	/**
	 * Apply the filter to get the avatar.
	 * If the filter is not set, the default avatar will be used.
	 *
	 * @return false|string
	 */
	public static function get_avatar() {
		$avatar = \apply_filters( 'wapuugotchi_avatar', false );

		if ( false === $avatar ) {
			$default_config_url = \plugin_dir_url( __DIR__ ) . 'assets/avatar.svg';
			$response           = wp_remote_get( $default_config_url );

			if ( is_wp_error( $response ) ) {
				return false;
			}

			$avatar = wp_remote_retrieve_body( $response );
			if ( empty( $avatar ) ) {
				return false;
			}
		}

		return $avatar;
	}
}
