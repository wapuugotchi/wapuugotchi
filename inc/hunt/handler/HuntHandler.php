<?php
/**
 * The Avatar Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Hunt\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 */
class HuntHandler {

	const CURRENT_HUNT_CONFIG = 'wapuugotchi_hunt_current';
	/**
	 * Apply filter for the hunt.
	 *
	 * @return array The hunt.
	 */
	public static function get_all_hunts() {
		$hunts = \apply_filters( 'wapuugotchi_hunt__filter', array() );

		if ( false === $hunts ) {
			$hunts = array();
		}

		return self::validate_hunts( $hunts );
	}

	/**
	 * Validate the hunt.
	 *
	 * @param array $hunt The hunt.
	 *
	 * @return array The validated hunt.
	 */
	private static function validate_hunts( $hunts ) {
		$validated_hunts = array();

		foreach ( $hunts as $hunt_item ) {
			if ( ! is_a( $hunt_item, 'Wapuugotchi\Hunt\Models\Hunt' ) ) {
				continue;
			}

			$validated_hunts[] = $hunt_item;
		}

		return $validated_hunts;
	}

	/**
	 * Get the hunt as array.
	 *
	 * @return array The hunt array.
	 */
	public static function get_hunts_array() {
		$hunt       = self::get_all_hunts();
		$hunt_array = array();

		if ( empty( $hunt ) ) {
			return array();
		}

		foreach ( $hunt as $hunt_item ) {
			$hunt_array[] = array(
				'id'           => $hunt_item->get_id(),
				'quest_text'   => $hunt_item->get_quest_text(),
				'success_text' => $hunt_item->get_success_text(),
				'page_name'    => $hunt_item->get_page_name(),
				'selectors'    => $hunt_item->get_selectors(),
				'state'        => $hunt_item->get_state(),
			);
		}

		return $hunt_array;
	}

	/**
	 * Get the shuffled hunt array.
	 *
	 * @return array The shuffled hunt array.
	 */
	public static function get_random_hunt() {
		$hunt_array = self::get_hunts_array();
		\shuffle( $hunt_array );

		return \reset( $hunt_array );
	}

	/**
	 * Get current hunt. If there is no current hunt, create a new one.
	 *
	 * @return \Wapuugotchi\Hunt\Models\Hunt The current hunt.
	 */
	private static function get_users_hunt () {
		$current_hunt = get_user_meta( \get_current_user_id(), self::CURRENT_HUNT_CONFIG, true );
		if ( empty( $current_hunt ) ) {
			$current_hunt = self::get_random_hunt();
			update_user_meta( \get_current_user_id(), self::CURRENT_HUNT_CONFIG, $current_hunt );
		}

		return $current_hunt;
	}

	/**
	 * Get the hunt id list.
	 *
	 * @return array The hunt id list.
	 */
	private static function get_hunt_id_list() {
		$hunt_array = self::get_hunts_array();
		$hunt_ids   = array();

		foreach ( $hunt_array as $hunt_item ) {
			$hunt_ids[] = $hunt_item['id'];
		}

		return $hunt_ids;
	}

	/**
	 * Get the current hunt.
	 *
	 * @return \Wapuugotchi\Hunt\Models\Hunt The current hunt.
	 */
	public static function get_current_hunt() {
		$all_hunts = self::get_hunt_id_list();
		$user_hunt = self::get_users_hunt();

		if ( empty( $user_hunt ) || ! isset( $user_hunt['id'] ) ) {
			return self::get_new_hunt();
		}
		if ( ! in_array( $user_hunt['id'], $all_hunts, true ) ) {
			return self::get_new_hunt();
		}

		return $user_hunt;
	}

	/**
	 * Get a new hunt.
	 *
	 * @return \Wapuugotchi\Hunt\Models\Hunt The new hunt.
	 */
	public static function get_new_hunt() {
		$current_hunt = self::get_random_hunt();
		update_user_meta( \get_current_user_id(), self::CURRENT_HUNT_CONFIG, $current_hunt );

		return $current_hunt;
	}
}
