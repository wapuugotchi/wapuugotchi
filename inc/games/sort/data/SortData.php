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
			__( 'Correct! Subscribers can only read content. Authors write and publish their own posts. Administrators have full control over the entire site.', 'wapuugotchi' ),
			__( 'Not quite. Subscribers can only read, Authors publish their own posts, and Administrators control the entire site. So the correct order is Subscriber → Author → Administrator.', 'wapuugotchi' ),
			__( 'Editor', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_2',
			__( 'Sort these WordPress hooks in the order they fire!', 'wapuugotchi' ),
			array( __( 'plugins_loaded', 'wapuugotchi' ), __( 'init', 'wapuugotchi' ), __( 'wp_head', 'wapuugotchi' ) ),
			__( 'Correct! plugins_loaded fires once all plugins are registered. init runs when core is ready. wp_head outputs tags into the HTML head.', 'wapuugotchi' ),
			__( 'Not quite. plugins_loaded fires first when all plugins are registered, then init when core is ready, and wp_head when the HTML head is output. So the correct order is plugins_loaded → init → wp_head.', 'wapuugotchi' ),
			__( 'save_post', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_3',
			__( 'Sort the steps to install a WordPress plugin!', 'wapuugotchi' ),
			array( __( 'Search', 'wapuugotchi' ), __( 'Install', 'wapuugotchi' ), __( 'Activate', 'wapuugotchi' ) ),
			__( 'Correct! First search for the plugin in the official WordPress Plugin Repository, then install it with one click, and finally activate it so WordPress can use it.', 'wapuugotchi' ),
			__( 'Not quite. You first search for the plugin in the official WordPress Plugin Repository, then install it with one click, and finally activate it so WordPress can use it. So the correct order is Search → Install → Activate.', 'wapuugotchi' ),
			__( 'Update', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_4',
			__( 'Sort these post statuses in a typical publication workflow!', 'wapuugotchi' ),
			array( __( 'Draft', 'wapuugotchi' ), __( 'Pending', 'wapuugotchi' ), __( 'Published', 'wapuugotchi' ) ),
			__( 'Correct! A post starts as a Draft while you work on it, moves to Pending when it needs review, and becomes Published once it is live for everyone.', 'wapuugotchi' ),
			__( 'Not quite. A post starts as a Draft while you write it, moves to Pending when it awaits review, and becomes Published once it is live. So the correct order is Draft → Pending → Published.', 'wapuugotchi' ),
			__( 'Trash', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_5',
			__( 'Sort these WordPress versions from oldest to newest!', 'wapuugotchi' ),
			array( __( 'WordPress 0.7', 'wapuugotchi' ), __( 'WordPress 3.0', 'wapuugotchi' ), __( 'WordPress 5.0', 'wapuugotchi' ) ),
			__( 'Correct! WordPress 0.7 was the very first public release in 2003. Version 3.0 introduced custom post types in 2010. Version 5.0 launched the block editor in 2018.', 'wapuugotchi' ),
			__( 'Not quite. WordPress 0.7 launched in 2003, version 3.0 brought custom post types in 2010, and version 5.0 introduced the block editor in 2018. So the correct order is 0.7 → 3.0 → 5.0.', 'wapuugotchi' ),
			__( 'WordPress 4.0', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_6',
			__( 'Sort the steps to apply a new WordPress theme!', 'wapuugotchi' ),
			array( __( 'Install Theme', 'wapuugotchi' ), __( 'Activate Theme', 'wapuugotchi' ), __( 'Customize Theme', 'wapuugotchi' ) ),
			__( 'Correct! First install the theme to add it to WordPress, then activate it to set it as the live design, and finally customize colors, fonts and layout to your liking.', 'wapuugotchi' ),
			__( 'Not quite. You first install the theme to add it to WordPress, then activate it to make it live, and finally customize colors, fonts and layout. So the correct order is Install → Activate → Customize.', 'wapuugotchi' ),
			__( 'Delete Theme', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_7',
			__( 'Sort these from most to least specific content level!', 'wapuugotchi' ),
			array( __( 'Post', 'wapuugotchi' ), __( 'Category', 'wapuugotchi' ), __( 'Site', 'wapuugotchi' ) ),
			__( 'Correct! A Post is a single piece of content. A Category groups related posts together. The Site contains all content across the entire website.', 'wapuugotchi' ),
			__( 'Not quite. A Post is a single piece of content, a Category groups related posts, and the Site contains everything. So the correct order is Post → Category → Site, from most to least specific.', 'wapuugotchi' ),
			__( 'Tag', 'wapuugotchi' )
		);

		$sort[] = new Sort(
			'wp_sort_8',
			__( 'Sort the steps to launch a WordPress site!', 'wapuugotchi' ),
			array( __( 'Buy Domain', 'wapuugotchi' ), __( 'Install WordPress', 'wapuugotchi' ), __( 'Publish Content', 'wapuugotchi' ) ),
			__( 'Correct! First buy a domain to claim your web address, then install WordPress on your server, and finally publish your content to go live.', 'wapuugotchi' ),
			__( 'Not quite. You first buy a domain to claim your address, then install WordPress on your server, and finally publish your content to go live. So the correct order is Buy Domain → Install WordPress → Publish Content.', 'wapuugotchi' ),
			__( 'Set Up Hosting', 'wapuugotchi' )
		);

		return $sort;
	}
}
