<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\Handler;

use function get_current_user_id;
use function get_user_meta;
use function update_user_meta;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class BalanceHandler
 */
class BalanceHandler {

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
		if ( $balance >= 0 ) {
			update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', $balance );

			return true;
		} else {
			return false;
		}
	}

	/**
	 * Get the balance of the current user
	 *
	 * @return int
	 */
	public static function get_balance() {
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha' ) ) ) {
			update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', 100 );
		}

		return get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true );
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
		update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', $balance );
	}
}
