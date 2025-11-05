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
	 * Maximum number of attempts to acquire lock.
	 *
	 * @var int
	 */
	const MAX_LOCK_ATTEMPTS = 10;

	/**
	 * Lock timeout in seconds.
	 *
	 * @var int
	 */
	const LOCK_TIMEOUT = 5;

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
		// Acquire lock to prevent race conditions.
		$lock = self::acquire_lock();
		if ( ! $lock ) {
			return false;
		}

		try {
			// Get current balance inside lock.
			$balance = self::get_balance();
			$price   = $item['meta']['price'];

			// Check if user has enough balance.
			if ( $balance < $price ) {
				self::release_lock();
				return false;
			}

			// Deduct balance.
			$new_balance = $balance - $price;

			// Update balance.
			\update_user_meta( \get_current_user_id(), self::BALANCE_KEY, $new_balance );

			self::release_lock();
			return true;
		} catch ( \Exception $e ) {
			// Always release lock on error.
			self::release_lock();
			return false;
		}
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
	 * @return bool True on success, false on failure.
	 */
	public static function increase_balance( $amount ) {
		// Acquire lock to prevent race conditions.
		$lock = self::acquire_lock();
		if ( ! $lock ) {
			return false;
		}

		try {
			// Get current balance inside lock.
			$balance = self::get_balance();

			// Add amount.
			$new_balance = $balance + $amount;

			// Update balance.
			\update_user_meta( \get_current_user_id(), self::BALANCE_KEY, $new_balance );

			self::release_lock();
			return true;
		} catch ( \Exception $e ) {
			// Always release lock on error.
			self::release_lock();
			return false;
		}
	}

	/**
	 * Acquire a lock for balance operations.
	 *
	 * Uses WordPress transients as a simple locking mechanism to prevent
	 * race conditions when multiple requests try to modify balance simultaneously.
	 *
	 * @return bool True if lock acquired, false otherwise.
	 */
	private static function acquire_lock() {
		$lock_key = 'wapuugotchi_balance_lock_' . \get_current_user_id();
		$attempts = 0;

		while ( $attempts < self::MAX_LOCK_ATTEMPTS ) {
			// Try to set the transient. If it doesn't exist, set_transient returns true.
			if ( \set_transient( $lock_key, true, self::LOCK_TIMEOUT ) ) {
				return true;
			}

			// Lock exists, wait a bit and retry.
			usleep( 100000 ); // 0.1 seconds.
			$attempts++;
		}

		return false;
	}

	/**
	 * Release the balance operation lock.
	 *
	 * @return void
	 */
	private static function release_lock() {
		$lock_key = 'wapuugotchi_balance_lock_' . \get_current_user_id();
		\delete_transient( $lock_key );
	}
}
