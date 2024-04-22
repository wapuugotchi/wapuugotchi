<?php
/**
 * The QuestStart Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar\Filters;

use Wapuugotchi\Avatar\Models\Message;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestStart
 */
class Messages {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_speech_bubble', array( $this, 'add_wapuugotchi_messages' ) );
	}

	/**
	 * Initialization filter for QuestStart
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Message[]
	 */
	public function add_wapuugotchi_messages( $quests ) {
		$default_quest = array(
			new Message( 'first_start_1', __( 'Thank you for giving me a home! &#10084;&#65039;', 'wapuugotchi' ), 'info', 'Wapuugotchi\Avatar\Filters\Messages::is_active', 'Wapuugotchi\Avatar\Filters\Messages::handle_submit' ),
		);

		return array_merge( $default_quest, $quests );
	}

	/**
	 * Get true.
	 *
	 * @return bool
	 */
	public static function is_active() {
		return \get_transient( 'wapuugotchi_first_submit' ) === false;
	}

	/**
	 * Set the transient.
	 *
	 * @return bool
	 */
	public static function handle_submit() {
		return \set_transient( 'wapuugotchi_first_submit', true, 60 );
	}
}
