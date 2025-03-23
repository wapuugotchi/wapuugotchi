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
			'wp_hunt_2',
			'Find me! I\'m hiding where you can create new posts.',
			'Great!',
			'edit-post',
			array( '#cat', '#doaction2', '#post-query-submit', '#doaction', '#doactiondoaction' )
		);

		return $hunt;
	}
}
