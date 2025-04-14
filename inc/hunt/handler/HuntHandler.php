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


	// Statische Variable für Hunts
	private static array $hunts_cache = [];

	/**
	 * Holt alle verfügbaren Hunts und validiert sie.
	 *
	 * @return array Die validierten Hunts.
	 */
	public static function get_all_hunts(): array {
		if (empty(self::$hunts_cache)) {
			$hunts = \apply_filters('wapuugotchi_hunt__filter', array());
			self::$hunts_cache = self::validate_hunts($hunts ?: array());
		}

		return self::$hunts_cache;
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
		if ( ! self::validate_hunt( $current_hunt) ) {
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
		$user_hunt = self::get_users_hunt();

		if ( ! self::validate_hunt( $user_hunt) ) {
			return self::get_new_hunt();
		}

		return $user_hunt;
	}

	public static function is_existing_hunt( $hunt_id ) {
		$all_hunts = self::get_hunt_id_list();
		if ( ! in_array( $hunt_id, $all_hunts, true ) ) {
			return false;
		}

		return true;
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

	/**
	 * Validate the hunt.
	 *
	 * @param array $hunt The hunt.
	 *
	 * @return bool True if valid, false otherwise.
	 */
	private static function validate_hunt( $hunt ) {
		if ( ! is_array( $hunt ) ) {
			return false;
		}
		$required_keys = [ 'id', 'quest_text', 'success_text', 'page_name', 'selectors', 'state' ];

		foreach ( $required_keys as $key ) {
			if ( ! array_key_exists( $key, $hunt ) ) {
				return false;
			}
		}

		return true;
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
}
