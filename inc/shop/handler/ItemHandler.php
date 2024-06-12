<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\Handler;

use Wapuugotchi\Shop\Services\CollectionService;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class ItemHandler
 */
class ItemHandler {

	/**
	 * Get the items by id.
	 *
	 * @param string $id The id of the item.
	 * @param string $category The category of the item.
	 *
	 * @throws \Exception If the item could not be unlocked.
	 */
	public static function get_items_by_id( $id, $category ) {
		$items = self::get_items();
		if ( ! isset( $items[ $category ] ) ) {
			return false;
		}

		if ( ! isset( $items[ $category ][ $id ] ) ) {
			return false;
		}

		return $items[ $category ][ $id ];
	}

	/**
	 * The all items.
	 *
	 * @throws \Exception If the item could not be unlocked.
	 */
	public static function get_items() {
		$collection   = CollectionService::get_collection();
		$bought_items = self::get_unlocked_items();

		if ( ! is_array( $collection ) ) {
			return array();
		}

		$items = array();
		foreach ( $collection as $category ) {
			if ( ! isset( $category['slug'], $category['items'] ) ) {
				continue;
			}

			$items[ $category['slug'] ] = array();
			foreach ( $category['items'] as $key => $item ) {
				if ( 0 !== $item['meta']['deactivated'] ) {
					continue;
				}
				if ( in_array( $item['meta']['key'], $bought_items, true ) ) {
					$item['meta']['price'] = 0;  // setting the price to 0 if bought.
				}
				$items[ $category['slug'] ][ $item['meta']['key'] ] = $item;
			}

			// Sortieren der Items in dieser Kategorie nach Preis, Schlüssel beibehalten.
			uasort(
				$items[ $category['slug'] ],
				function ( $a, $b ) {
					return $a['meta']['price'] <=> $b['meta']['price'];
				}
			);
		}

		return $items;
	}

	/**
	 * Give all already unlocked items.
	 *
	 * @return array The unlocked items.
	 *
	 * @throws \Exception If the item could not be unlocked.
	 */
	public static function get_unlocked_items() {
		$unlocked_items = \get_user_meta( \get_current_user_id(), 'wapuugotchi_unlocked_items', true );
		if ( ! is_array( $unlocked_items ) ) {
			return array();
		}

		return $unlocked_items;
	}

	/**
	 * Check if the item is already unlocked.
	 *
	 * @param string $id The id of the item.
	 *
	 * @return bool
	 * @throws \Exception If the item could not be unlocked.
	 */
	public static function is_item_unlocked( $id ) {
		$unlocked_items = self::get_unlocked_items();
		if ( ! is_array( $unlocked_items ) ) {
			return false;
		}

		return in_array( $id, $unlocked_items, true );
	}

	/**
	 * Unlock an item by id.
	 *
	 * @param string $id The id of the item.
	 *
	 * @return bool
	 * @throws \Exception If the item could not be unlocked.
	 */
	public static function unlock_item( $id ) {
		$unlocked_items = self::get_unlocked_items();
		if ( in_array( $id, $unlocked_items, true ) ) {
			return false;
		}

		$unlocked_items[] = $id;
		\update_user_meta( \get_current_user_id(), 'wapuugotchi_unlocked_items', $unlocked_items );

		return true;
	}
}
