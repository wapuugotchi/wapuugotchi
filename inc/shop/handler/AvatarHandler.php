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
	 * The key for the avatar configuration user meta.
	 *
	 * @var string
	 */
	const AVATAR_CONFIG_KEY = 'wapuugotchi_avatar';
	/**
	 * The key for the avatar svg user meta.
	 *
	 * @var string
	 */
	const AVATAR_SVG_KEY = 'wapuugotchi_shop_svg';

	/**
	 * Get the avatar configuration of the current user
	 *
	 * @return array
	 */
	public static function get_avatar_config() {
		$config = \get_user_meta( \get_current_user_id(), 'wapuugotchi_avatar', true );
		if ( ! empty( $config ) ) {
			return $config;
		}

		$config = \json_decode(
			\file_get_contents( \plugin_dir_path( __DIR__ ) . 'assets/avatar.json' ),
			true
		);
		self::update( self::AVATAR_CONFIG_KEY, $config );

		return $config;
	}

	/**
	 * Update the avatar configuration of the current user
	 *
	 * @param array $data The data to update the avatar with.
	 *
	 * @return bool
	 */
	public static function update_avatar_config( $data ) {
		return self::update( self::AVATAR_CONFIG_KEY, $data );
	}

	/**
	 * Get the avatar svg of the current user
	 *
	 * @return string
	 */
	public static function get_avatar_svg() {
		return \get_user_meta( \get_current_user_id(), self::AVATAR_SVG_KEY, true );
	}

	/**
	 * Update the avatar svg of the current user
	 *
	 * @param string $svg The svg to update the avatar with.
	 *
	 * @return bool
	 */
	public static function update_avatar_svg( $svg ) {
		return self::update( self::AVATAR_SVG_KEY, $svg );
	}

	/**
	 * Update the user meta with the given key and value.
	 *
	 * @param string $key The key to update.
	 * @param mixed  $value The value to update the key with.
	 *
	 * @return bool
	 */
	private static function update( $key, $value ) {
		$result = \update_user_meta(
			\get_current_user_id(),
			$key,
			$value
		);

		if ( is_int( $result ) ) {
			return true;
		}

		return $result;
	}
}
