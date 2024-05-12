<?php
/**
 * Contains methods for handling the balance of the user.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class BalanceHandler
 */
class BalanceHandler {

	/**
	 * The key for the balance user meta.
	 *
	 * @var string
	 */
	const BALANCE_KEY = 'wapuugotchi_balance';

	/**
	 * Initialize the balance handler and set the balance to 0 if it is not set.
	 *
	 * @return void
	 */
	public static function init() {
		// Check if the user has a balance and set it to 0 if not.
		if ( empty( \get_user_meta( \get_current_user_id(), self::BALANCE_KEY ) ) ) {
			\update_user_meta( \get_current_user_id(), self::BALANCE_KEY, 0 );
		}
	}

	/**
	 * Pay for an item
	 *
	 * @param array $item The item to pay for.
	 *
	 * @return bool
	 */
	public static function decrease_balance( $item ) {
		$balance  = self::get_balance();
		$balance -= $item['meta']['price'];
		if ( $balance < 0 ) {
			return false;
		}

		\update_user_meta( \get_current_user_id(), self::BALANCE_KEY, $balance );

		return true;
	}

	/**
	 * Get the balance of the current user
	 *
	 * @return int
	 */
	public static function get_balance() {
		return \get_user_meta( \get_current_user_id(), self::BALANCE_KEY, true );
	}

	/**
	 * Increase the balance of the current user
	 *
	 * @param int $amount The amount to increase the balance by.
	 *
	 * @return void
	 */
	public static function increase_balance( $amount ) {
		$balance  = self::get_balance();
		$balance += $amount;
		\update_user_meta( \get_current_user_id(), self::BALANCE_KEY, $balance );
	}
}
