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
 * Class CategoryHandler
 */
class CategoryHandler {
	const MAIN_CATEGORY = 'fur';

	/**
	 * Gets the list of categories.
	 * The MAIN_CATEGORY is the category that is displayed first in the shop.
	 *
	 * @throws \Exception If the collection could not be retrieved.
	 */
	public static function get_categories() {
		$collection = CollectionService::get_collection();
		if ( empty( $collection ) || ! is_array( $collection ) ) {
			return array();
		}

		$categories = array();
		foreach ( $collection as $category ) {
			if ( empty( $category['slug'] ) || empty( $category['caption'] ) || empty( $category['image'] ) ) {
				continue;
			}

			$categories[ $category['slug'] ] = array(
				'caption' => $category['caption'],
				'image'   => $category['image'],
			);
		}

		return self::set_main_category_first( $categories );
	}

	/**
	 * Moves the main category to the front of the category list.
	 *
	 * @param array $categories The category list.
	 *
	 * @return array The updated category list.
	 */
	private static function set_main_category_first( array $categories ) {
		if ( key_exists( self::MAIN_CATEGORY, $categories ) ) {
			$main_category = $categories[ self::MAIN_CATEGORY ];
			unset( $categories[ self::MAIN_CATEGORY ] );
			$categories = array_merge( array( self::MAIN_CATEGORY => $main_category ), $categories );
		}

		return $categories;
	}
}
