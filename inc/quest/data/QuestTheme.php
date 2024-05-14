<?php
/**
 * The QuestTheme Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Data;

use Wapuugotchi\Quest\Models\Quest;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestTheme
 */
class QuestTheme {

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

	/**
	 * Initialization filter for QuestTheme
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public static function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new Quest( 'cleanup_themes_1', null, __( 'Remove all unused themes', 'wapuugotchi' ), __( 'You cleaned up! &#129529;', 'wapuugotchi' ) . PHP_EOL . 'We have only one theme now.', 'success', 100, 2, 'Wapuugotchi\Quest\Data\QuestTheme::always_true', 'Wapuugotchi\Quest\Data\QuestTheme::cleanup_themes_completed_1' ),
		);

		return array_merge( $default_quest, $quests );
	}
}
