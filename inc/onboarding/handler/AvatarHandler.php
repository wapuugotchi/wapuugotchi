<?php
/**
 * The Avatar Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
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
			$default = WAPUUGOTCHI_PATH . 'inc/onboarding/assets/avatar.svg';
			if ( \file_exists( $default ) && \is_readable( $default ) ) {
				// phpcs:ignore
				$avatar = \file_get_contents( $default );
			}
		}

		return $avatar;
	}
}
