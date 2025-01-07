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

	/**
	 * Apply filter for the hunt.
	 * @return array The hunt.
	 */
	public static function get_hunt() {
		$hunt = \apply_filters( 'wapuugotchi_hunt__filter', array() );

		if ( false === $hunt ) {
			$hunt = array();
		}

		return self::validate_hunt( $hunt );
	}

	/**
	 * Validate the hunt.
	 *
	 * @param array $hunt The hunt.
	 *
	 * @return array The validated hunt.
	 */
	private static function validate_hunt( $hunt ) {
		$validated_hunt = array();

		foreach ( $hunt as $hunt_item ) {
			if ( ! is_a( $hunt_item, 'Wapuugotchi\Hunt\Models\Hunt' ) ) {
				continue;
			}

			$validated_hunt[] = $hunt_item;
		}

		return $validated_hunt;
	}

	/**
	 * Get the hunt as array.
	 *
	 * @return array The hunt array.
	 */
	public static function get_hunt_array () {
		$hunt 		= self::get_hunt();
		$hunt_array = array();

		if ( empty( $hunt ) ) {
			return array();
		}

		foreach ( $hunt as $hunt_item ) {
			$hunt_array[] = array(
				'id'           	=> $hunt_item->get_id(),
				'quest_text'   	=> $hunt_item->get_quest_text(),
				'success_text' 	=> $hunt_item->get_success_text(),
				'failure_text'	=> $hunt_item->get_failure_text(),
				'page_name'   	=> $hunt_item->get_page_name(),
				'selector_name' => $hunt_item->get_selector_name(),
			);
		}

		return $hunt_array;
	}

	/**
	 * Get the shuffled hunt array.
	 *
	 * @return array The shuffled hunt array.
	 */
	public static function get_shuffled_hunt_array() {
		$hunt_array = self::get_hunt_array();
		shuffle( $hunt_array );

		return $hunt_array;
	}
}
