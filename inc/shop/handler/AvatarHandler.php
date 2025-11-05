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
	const AVATAR_CONFIG_KEY = 'wapuugotchi_shop_avatar_config';
	/**
	 * The key for the avatar svg user meta.
	 *
	 * @var string
	 */
	const AVATAR_SVG_KEY = 'wapuugotchi_shop_svg';

	/**
	 * Initialize the avatar handler.
	 *
	 * @return void
	 */
	public static function init() {
		self::init_avatar_config();
	}

	/**
	 * Initialize the avatar configuration and set it to the default if it is not set.
	 *
	 * @return void
	 */
	private static function init_avatar_config() {
		$config = \get_user_meta( \get_current_user_id(), self::AVATAR_CONFIG_KEY, true );
		if ( ! empty( $config ) ) {
			return;
		}

		$default_config_url = \plugin_dir_url( __DIR__ ) . 'assets/avatar.json';
		$response           = wp_remote_get( $default_config_url );

		if ( is_wp_error( $response ) ) {
			// Handle error.
			return;
		}

		$body = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {
			// Could not retrieve the body.
			return;
		}

		$config = \json_decode( $body, true );
		if ( false === $config ) {
			// Could not decode default avatar config file.
			return;
		}

		self::update( self::AVATAR_CONFIG_KEY, $config );
	}

	/**
	 * Get the avatar configuration of the current user
	 *
	 * @return array
	 */
	public static function get_avatar_config() {
		return \get_user_meta( \get_current_user_id(), self::AVATAR_CONFIG_KEY, true );
	}

	/**
	 * Update the avatar configuration of the current user
	 *
	 * @param array $data The data to update the avatar with.
	 *
	 * @return void
	 */
	public static function update_avatar_config( $data ) {
		self::update( self::AVATAR_CONFIG_KEY, $data );
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
	 * @return void
	 */
	public static function update_avatar_svg( $svg ) {
		$sanitized_svg = self::sanitize_svg( $svg );
		self::update( self::AVATAR_SVG_KEY, $sanitized_svg );
	}

	/**
	 * Sanitize SVG content to prevent XSS attacks.
	 *
	 * @param string $svg The SVG content to sanitize.
	 *
	 * @return string The sanitized SVG content.
	 */
	private static function sanitize_svg( $svg ) {
		// Define allowed SVG tags and attributes.
		$allowed_tags = array(
			'svg'        => array(
				'xmlns'       => true,
				'viewbox'     => true,
				'width'       => true,
				'height'      => true,
				'fill'        => true,
				'class'       => true,
				'id'          => true,
				'x'           => true,
				'y'           => true,
				'version'     => true,
				'xmlns:xlink' => true,
			),
			'g'          => array(
				'id'        => true,
				'class'     => true,
				'transform' => true,
				'fill'      => true,
				'stroke'    => true,
				'opacity'   => true,
			),
			'path'       => array(
				'd'         => true,
				'fill'      => true,
				'stroke'    => true,
				'class'     => true,
				'id'        => true,
				'transform' => true,
				'opacity'   => true,
			),
			'circle'     => array(
				'cx'        => true,
				'cy'        => true,
				'r'         => true,
				'fill'      => true,
				'stroke'    => true,
				'class'     => true,
				'id'        => true,
				'transform' => true,
			),
			'ellipse'    => array(
				'cx'        => true,
				'cy'        => true,
				'rx'        => true,
				'ry'        => true,
				'fill'      => true,
				'stroke'    => true,
				'class'     => true,
				'id'        => true,
				'transform' => true,
			),
			'rect'       => array(
				'x'         => true,
				'y'         => true,
				'width'     => true,
				'height'    => true,
				'fill'      => true,
				'stroke'    => true,
				'class'     => true,
				'id'        => true,
				'rx'        => true,
				'ry'        => true,
				'transform' => true,
			),
			'line'       => array(
				'x1'     => true,
				'y1'     => true,
				'x2'     => true,
				'y2'     => true,
				'stroke' => true,
				'class'  => true,
				'id'     => true,
			),
			'polyline'   => array(
				'points' => true,
				'fill'   => true,
				'stroke' => true,
				'class'  => true,
				'id'     => true,
			),
			'polygon'    => array(
				'points' => true,
				'fill'   => true,
				'stroke' => true,
				'class'  => true,
				'id'     => true,
			),
			'text'       => array(
				'x'         => true,
				'y'         => true,
				'fill'      => true,
				'class'     => true,
				'id'        => true,
				'transform' => true,
			),
			'tspan'      => array(
				'x'     => true,
				'y'     => true,
				'fill'  => true,
				'class' => true,
				'id'    => true,
			),
			'defs'       => array(),
			'use'        => array(
				'href'       => true,
				'xlink:href' => true,
				'x'          => true,
				'y'          => true,
				'transform'  => true,
			),
			'clipPath'   => array(
				'id' => true,
			),
			'linearGradient' => array(
				'id' => true,
			),
			'radialGradient' => array(
				'id' => true,
			),
			'stop'       => array(
				'offset'     => true,
				'stop-color' => true,
				'stop-opacity' => true,
			),
		);

		// Sanitize using wp_kses with allowed SVG tags.
		$sanitized = \wp_kses( $svg, $allowed_tags );

		// Additional security: Remove any javascript: or data: protocols.
		$sanitized = preg_replace( '/javascript:/i', '', $sanitized );
		$sanitized = preg_replace( '/data:text\/html/i', '', $sanitized );

		// Remove event handlers that might have slipped through.
		$sanitized = preg_replace( '/\s*on\w+\s*=\s*["\'][^"\']*["\']/i', '', $sanitized );

		return $sanitized;
	}

	/**
	 * Update the user meta with the given key and value.
	 *
	 * @param string $key The key to update.
	 * @param mixed  $value The value to update the key with.
	 *
	 * @return void
	 */
	private static function update( $key, $value ) {
		\update_user_meta(
			\get_current_user_id(),
			$key,
			$value
		);
	}
}
