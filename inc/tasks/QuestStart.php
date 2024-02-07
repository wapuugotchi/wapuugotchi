<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi\Tasks;

use Wapuugotchi\Wapuugotchi\Models\Quest;

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
			new Quest( 'first_start_1', null, __( 'The Beginning', 'wapuugotchi' ), __( 'Embark into an amusing adventure in the WordPress realm with your Wapuu. Your noble endeavor giving him a home on your site, is the first step toward countless whimsical quests, unforeseen challenges, and surely a plethora of enthralling escapades. Are you ready to dive into the world of your WordPress and embrace the wild journey that lies ahead?', 'wapuugotchi' ), __( 'Thank you for giving me a home! &#10084;&#65039;', 'wapuugotchi' ), 'success', 100, 15, 'Wapuugotchi\Wapuugotchi\Tasks\QuestStart::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestStart::always_true' ),
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
