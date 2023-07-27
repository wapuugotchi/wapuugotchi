<?php
/**
 * The QuestTheme Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestTheme
 */
class QuestTheme {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	/**
	 * Initialization filter for QuestTheme
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'cleanup_themes_1', null, __( 'Remove all unused themes', 'wapuugotchi' ), __( 'You cleaned up! &#129529;', 'wapuugotchi' ) . PHP_EOL . 'We have only one theme now.', 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestTheme::always_true', 'Wapuugotchi\Wapuugotchi\QuestTheme::cleanup_themes_completed_1' ),
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

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function cleanup_themes_completed_1() {
		return ( count( wp_get_themes() ) === 1 );
	}
}
