<?php
/**
 * The QuestDate Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop\data;

use Wapuugotchi\Mission\Handler\MissionHandler;
use Wapuugotchi\Shop\Handler\ItemHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestDate
 */
class Quests {
	/**
	 * Get true.
	 *
	 * @return true
	 */
	public static function always_true() {
		return true;
	}

	/**
	 * Get true.
	 *
	 * @return bool
	 */
	public static function completed() {
		$items = ItemHandler::get_unlocked_items();
		return ! empty( $items );
	}

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public static function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Quest\Models\Quest( 'unlock_first_item', null, __( 'Unlock your first item', 'wapuugotchi' ), __( 'Victory! You unlocked your first item! &#128170;', 'wapuugotchi' ), 'success', 100, 5, 'Wapuugotchi\Shop\Data\Quests::always_true', 'Wapuugotchi\Shop\Data\Quests::completed' ),
		);

		return array_merge( $default_quest, $quests );
	}
}
