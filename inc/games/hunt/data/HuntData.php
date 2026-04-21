<?php
/**
 * The QuizWordPress Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Hunt\Data;

use Wapuugotchi\Hunt\Models\Hunt;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class AutoMessage
 */
class HuntData {

	/**
	 * Initialization filter for hunt.
	 *
	 * @param array $hunt The elements.
	 *
	 * @return array
	 */
	public static function add_wp_hunt( $hunt ) {
		$hunt[] = new Hunt(
			'wp_hunt_1',
			'Find me! I\'m hiding where you can create new posts.',
			'Great!',
			'edit-post',
			array( '#cat', '#doaction2', '#post-query-submit', '#doaction', '#doactiondoaction' )
		);

		$hunt[] = new Hunt(
			'wp_hunt_2',
			'Find me! I\'m hiding where you can install new plugins.',
			'Awesome!',
			'plugins',
			array( '#doaction2', '#plugin-search-input', '#doaction', '#doactiondoaction' )
		);

		$hunt[] = new Hunt(
			'wp_hunt_3',
			'Find me! I\'m hiding where users can be managed.',
			'You got it!',
			'users',
			array( '#doaction2', '#plugin-search-input', '#doaction', '#doactiondoaction' )
		);

		$hunt[] = new Hunt(
			'wp_hunt_4',
			'Find me! I\'m hiding where you can manage your themes.',
			'Great job!',
			'themes',
			array( '#wp-filter-search-input' )
		);

		$hunt[] = new Hunt(
			'wp_hunt_5',
			'Find me! I\'m hiding where you can manage your comments.',
			'You found me!',
			'edit-comments',
			array( '#doaction2', '#plugin-search-input', '#doaction', '#doactiondoaction' )
		);

		return $hunt;
	}
}
