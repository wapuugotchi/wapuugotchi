<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\Handler;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class BalanceHandler
 */
class BalanceHandler {

	/**
	 * Get the balance of the current user
	 *
	 * @return int
	 */
	public static function get_balance() {
		if ( empty( \get_user_meta( \get_current_user_id(), 'wapuugotchi_balance__alpha' ) ) ) {
			\update_user_meta( \get_current_user_id(), 'wapuugotchi_balance__alpha', 100 );
		}

		return \get_user_meta( \get_current_user_id(), 'wapuugotchi_balance__alpha', true );
	}

	/**
	 * Pay for an item
	 *
	 * @param array $item The item to pay for
	 *
	 * @return bool
	 */
	public static function pay_item( $item ) {
		$balance  = self::get_balance();
		$balance -= $item['meta']['price'];
		if ( $balance >= 0 ) {
			\update_user_meta( \get_current_user_id(), 'wapuugotchi_balance__alpha', $balance );
			return true;
		} else {
			return false;
		}
	}
}
