<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Filters;

use Wapuugotchi\Quest\Models\Quest;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestStart
 */
class QuestStart {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	/**
	 * Get true.
	 *
	 * @return true
	 */
	public static function always_true() {
		return true;
	}

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new Quest( 'first_start_1', null, __( 'Welcome to Wapuugotchi', 'wapuugotchi' ), __( 'Thank you for giving me a home! &#10084;&#65039;', 'wapuugotchi' ), 'success', 100, 15, 'Wapuugotchi\Quest\Filters\QuestStart::always_true', 'Wapuugotchi\Quest\Filters\QuestStart::always_true' ),
		);

		return array_merge( $default_quest, $quests );
	}
}
