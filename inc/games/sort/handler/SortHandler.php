<?php
/**
 * The SortHandler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Sort\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class SortHandler
 */
class SortHandler {

	/**
	 * Apply the filter to get the sort data.
	 * If the filter is not set, an empty array will be returned.
	 *
	 * @return array
	 */
	public static function get_sort() {
		$sort = \apply_filters( 'wapuugotchi_sort__filter', array() );

		if ( false === $sort ) {
			$sort = array();
		}

		return self::validate_sort( $sort );
	}

	/**
	 * Validate the sort data.
	 *
	 * @param array $sort The sort data.
	 *
	 * @return array The validated sort data.
	 */
	private static function validate_sort( $sort ) {
		foreach ( $sort as $index => $item ) {
			if ( ! is_a( $item, 'Wapuugotchi\Sort\Models\Sort' ) ) {
				unset( $sort[ $index ] );
				continue;
			}
		}

		return $sort;
	}

	/**
	 * Get the sort data as array with shuffled items.
	 *
	 * @return array
	 */
	public static function get_shuffled_sort_array() {
		$sort      = self::get_sort();
		$sort_array = array();

		if ( empty( $sort ) ) {
			return array();
		}

		foreach ( $sort as $item ) {
			$correct_order = $item->get_items();
			$items         = $correct_order;
			\shuffle( $items );

			$sort_array[] = array(
				'id'               => $item->get_id(),
				'question'         => $item->get_question(),
				'items'            => \array_values( $items ),
				'correct_order'    => $correct_order,
				'correct_notice'   => $item->get_correct_notice(),
				'incorrect_notice' => $item->get_incorrect_notice(),
			);
		}

		\shuffle( $sort_array );

		return $sort_array;
	}
}
