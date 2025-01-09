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
			'Where can you find the latest news about WordPress?',
			'Well done!',
			'The time is up! Next time you will make it!',
			'dashboard',
			'.welcome-panel-content'
		);

		$hunt[] = new Hunt(
			'wp_hunt_2',
			'Where cou you add a new post?',
			'Great!',
			'Time is up! You can do it better!',
			'dashboard',
			'.welcome-panel-content'
		);

		return $hunt;
	}
}
