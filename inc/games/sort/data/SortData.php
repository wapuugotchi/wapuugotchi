<?php
/**
 * The SortData Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Sort\Data;

use Wapuugotchi\Sort\Models\Sort;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class SortData
 */
class SortData {

	/**
	 * Initialization filter for Sort challenges.
	 *
	 * @param array $sort The sort challenges.
	 *
	 * @return array
	 */
	public static function add_wp_sort( $sort ) {
		$sort[] = new Sort(
			'wp_sort_1',
			__( 'Sort WordPress user roles from fewest to most permissions!', 'wapuugotchi' ),
			array( __( 'Subscriber', 'wapuugotchi' ), __( 'Author', 'wapuugotchi' ), __( 'Administrator', 'wapuugotchi' ) ),
			__( 'Correct! Subscriber → Author → Administrator, from fewest to most permissions.', 'wapuugotchi' ),
			__( 'Not quite. The correct order is Subscriber → Author → Administrator.', 'wapuugotchi' ),
			__( 'Editor', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_2',
			__( 'Sort these WordPress hooks in the order they fire!', 'wapuugotchi' ),
			array( __( 'plugins_loaded', 'wapuugotchi' ), __( 'init', 'wapuugotchi' ), __( 'wp_head', 'wapuugotchi' ) ),
			__( 'Correct! plugins_loaded fires first, then init, then wp_head.', 'wapuugotchi' ),
			__( 'Not quite. The correct order is plugins_loaded → init → wp_head.', 'wapuugotchi' ),
			__( 'save_post', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_3',
			__( 'Sort the steps to install a WordPress plugin!', 'wapuugotchi' ),
			array( __( 'Search', 'wapuugotchi' ), __( 'Install', 'wapuugotchi' ), __( 'Activate', 'wapuugotchi' ) ),
			__( 'Correct! First search for the plugin, then install, then activate it.', 'wapuugotchi' ),
			__( 'Not quite. The correct order is Search → Install → Activate.', 'wapuugotchi' ),
			__( 'Update', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_4',
			__( 'Sort these post statuses in a typical publication workflow!', 'wapuugotchi' ),
			array( __( 'Draft', 'wapuugotchi' ), __( 'Pending', 'wapuugotchi' ), __( 'Published', 'wapuugotchi' ) ),
			__( 'Correct! A post goes Draft → Pending → Published.', 'wapuugotchi' ),
			__( 'Not quite. The correct order is Draft → Pending → Published.', 'wapuugotchi' ),
			__( 'Trash', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_5',
			__( 'Sort these WordPress versions from oldest to newest!', 'wapuugotchi' ),
			array( __( 'WordPress 0.7', 'wapuugotchi' ), __( 'WordPress 3.0', 'wapuugotchi' ), __( 'WordPress 5.0', 'wapuugotchi' ) ),
			__( 'Correct! WordPress 0.7 (2003) → 3.0 (2010) → 5.0 (2018).', 'wapuugotchi' ),
			__( 'Not quite. Oldest to newest: WordPress 0.7 → 3.0 → 5.0.', 'wapuugotchi' ),
			__( 'WordPress 4.0', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_6',
			__( 'Sort the steps to apply a new WordPress theme!', 'wapuugotchi' ),
			array( __( 'Install Theme', 'wapuugotchi' ), __( 'Activate Theme', 'wapuugotchi' ), __( 'Customize Theme', 'wapuugotchi' ) ),
			__( 'Correct! First install the theme, then activate it, then customize.', 'wapuugotchi' ),
			__( 'Not quite. The correct order is Install → Activate → Customize.', 'wapuugotchi' ),
			__( 'Delete Theme', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_7',
			__( 'Sort these from most to least specific content level!', 'wapuugotchi' ),
			array( __( 'Post', 'wapuugotchi' ), __( 'Category', 'wapuugotchi' ), __( 'Site', 'wapuugotchi' ) ),
			__( 'Correct! Post → Category → Site, from most to least specific.', 'wapuugotchi' ),
			__( 'Not quite. The correct order is Post → Category → Site.', 'wapuugotchi' ),
			__( 'Tag', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_8',
			__( 'Sort the steps to launch a WordPress site!', 'wapuugotchi' ),
			array( __( 'Buy Domain', 'wapuugotchi' ), __( 'Install WordPress', 'wapuugotchi' ), __( 'Publish Content', 'wapuugotchi' ) ),
			__( 'Correct! Buy domain first, then install WordPress, then publish content.', 'wapuugotchi' ),
			__( 'Not quite. The correct order is Buy Domain → Install WordPress → Publish Content.', 'wapuugotchi' ),
			__( 'Set Up Hosting', 'wapuugotchi' )
		);

		return $sort;
	}
}
