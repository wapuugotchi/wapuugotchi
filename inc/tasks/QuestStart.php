<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

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
	 * Initialization filter for QuestStart
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'first_start_1', null, __( 'Welcome to Wapuugotchi', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'Thank you for giving me a home! &#10084;&#65039;', 'wapuugotchi' ), 'success', 100, 15, 'Wapuugotchi\Wapuugotchi\QuestStart::always_true', 'Wapuugotchi\Wapuugotchi\QuestStart::always_true' ),
		);

		return array_merge( $default_quest, $quests );
	}

	/**
	 * Get true.
	 *
	 * @return true
	 */
	public static function always_true() {
		return true;
	}
}
