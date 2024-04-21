<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\Handler;


use function Wapuugotchi\shop\get_user_meta;
use function Wapuugotchi\shop\update_user_meta;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class AvatarHandler
 */
class AvatarHandler {
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

	public static function update_avatar_config( $data ) {
		\update_user_meta(
			\get_current_user_id(),
			'wapuugotchi_avatar__alpha',
			$data
		);

		return true;
	}

	public static function get_avatar_svg() {
		return \get_user_meta( \get_current_user_id(), 'wapuugotchi_shop_svg__alpha', true );
	}

	public static function update_avatar_svg( $svg ) {
		\update_user_meta(
			\get_current_user_id(),
			'wapuugotchi_shop_svg__alpha',
			$svg
		);

		return true;
	}
}
