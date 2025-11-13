<?php
/**
 * Handles capability checks for WapuuGotchi plugin.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Capabilities
 *
 * Provides capability checking for WapuuGotchi features.
 * By default, any logged-in user can use WapuuGotchi features.
 * Site administrators can customize this using filters.
 */
class Capabilities {

	/**
	 * Check if current user can use WapuuGotchi features.
	 *
	 * By default, any logged-in user can use WapuuGotchi.
	 * This can be customized using the 'wapuugotchi_can_use' filter.
	 *
	 * @return bool True if user has permission, false otherwise.
	 */
	public static function can_use_wapuugotchi() {
		// Basic check: user must be logged in.
		if ( ! \is_user_logged_in() ) {
			return false;
		}

		/**
		 * Filter whether the current user can use WapuuGotchi features.
		 *
		 * By default, returns true for any logged-in user.
		 * Site administrators can add custom logic to restrict access.
		 *
		 * Example: Restrict to specific roles
		 * add_filter( 'wapuugotchi_can_use', function( $can_use ) {
		 *     return current_user_can( 'edit_posts' );
		 * } );
		 *
		 * @since 1.0.0
		 *
		 * @param bool $can_use Whether the user can use WapuuGotchi. Default true for logged-in users.
		 */
		return \apply_filters( 'wapuugotchi_can_use', true );
	}

	/**
	 * Check if current user can manage shop (purchase items, update avatar).
	 *
	 * @return bool True if user has permission, false otherwise.
	 */
	public static function can_use_shop() {
		if ( ! self::can_use_wapuugotchi() ) {
			return false;
		}

		/**
		 * Filter whether the current user can use the WapuuGotchi shop.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $can_use Whether the user can use the shop. Default matches can_use_wapuugotchi.
		 */
		return \apply_filters( 'wapuugotchi_can_use_shop', true );
	}

	/**
	 * Check if current user can earn balance/pearls.
	 *
	 * @return bool True if user has permission, false otherwise.
	 */
	public static function can_earn_balance() {
		if ( ! self::can_use_wapuugotchi() ) {
			return false;
		}

		/**
		 * Filter whether the current user can earn balance/pearls.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $can_earn Whether the user can earn balance. Default matches can_use_wapuugotchi.
		 */
		return \apply_filters( 'wapuugotchi_can_earn_balance', true );
	}

	/**
	 * Check if current user can use missions.
	 *
	 * @return bool True if user has permission, false otherwise.
	 */
	public static function can_use_missions() {
		if ( ! self::can_use_wapuugotchi() ) {
			return false;
		}

		/**
		 * Filter whether the current user can use missions.
		 *
		 * @since 1.0.0
		 *
		 * @param bool $can_use Whether the user can use missions. Default matches can_use_wapuugotchi.
		 */
		return \apply_filters( 'wapuugotchi_can_use_missions', true );
	}
}
