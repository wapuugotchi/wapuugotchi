<?php
/**
 * This file contains the AvatarHandler class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Gets and updates the avatar configuration and svg of the current user.
 */
class AvatarHandler {
	/**
	 * Get the avatar configuration of the current user
	 *
	 * @return array
	 */
	public static function get_avatar_config() {
		if ( empty( \get_user_meta( \get_current_user_id(), 'wapuugotchi_avatar__alpha', false ) ) ) {
			$config = file_get_contents( \plugin_dir_path( __DIR__ ) . 'assets/avatar.json' );
			\update_user_meta(
				\get_current_user_id(),
				'wapuugotchi_avatar__alpha',
				json_decode( $config, true )
			);
		}

		return \get_user_meta( \get_current_user_id(), 'wapuugotchi_avatar__alpha', true );
	}

	/**
	 * Update the avatar configuration of the current user
	 *
	 * @param array $data The data to update the avatar with.
	 *
	 * @return bool
	 */
	public static function update_avatar_config( $data ) {
		\update_user_meta(
			\get_current_user_id(),
			'wapuugotchi_avatar__alpha',
			$data
		);

		return true;
	}

	/**
	 * Get the avatar svg of the current user
	 *
	 * @return string
	 */
	public static function get_avatar_svg() {
		return \get_user_meta( \get_current_user_id(), 'wapuugotchi_shop_svg__alpha', true );
	}

	/**
	 * Update the avatar svg of the current user
	 *
	 * @param string $svg The svg to update the avatar with.
	 *
	 * @return bool
	 */
	public static function update_avatar_svg( $svg ) {
		\update_user_meta(
			\get_current_user_id(),
			'wapuugotchi_shop_svg__alpha',
			$svg
		);

		return true;
	}
}
