<?php
/**
 * The QuestDate Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestDate
 */
class QuestDate {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	/**
	 * Initialization filter for QuestDate
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_1', null, __( 'Consistent Conquest: The Decennial Challenge', 'wapuugotchi' ), __( 'Prepare for an exciting adventure in the dynamic world of WordPress, where you\'re challenged to log in on 10 different days. Navigate through the digital landscape, ward off procrastination monsters, and claim the revered title of the Dedicated Regular. Are you ready to embrace the challenge and leave your mark in the vibrant realm of WordPress?', 'wapuugotchi' ), __( 'Nice, you logged in for 10 consecutive days!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_1' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_2', 'login_1', __( 'Consistent Conquest: The Tenacity Trial', 'wapuugotchi' ), __( 'Prepare to test your persistence as you endeavor to log in for 20 days, facing increasingly formidable foes of distraction and embracing the mantle of the unwavering visitor.', 'wapuugotchi' ), __( 'Nice, you logged in for 20 consecutive days!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_2' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_3', 'login_2', __( 'Consistent Conquest: The Decaday Triumph', 'wapuugotchi' ), __( 'The challenge continues as you navigate through the digital landscape, logging in for 30 consecutive days, proving your continued commitment and seizing victory as a faithful stalwart of the WordPress kingdom.', 'wapuugotchi' ), __( 'Nice, you logged in for 30 consecutive days!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_3' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_4', 'login_3', __( 'Consistent Conquest: The 10-Day Crusade', 'wapuugotchi' ), __( 'Embark on this epic quest of regularity, where you must journey through the digital domain for 40 days and assert your unwavering presence as a valiant crusader dedicated to the WordPress realm.', 'wapuugotchi' ), __( 'Nice, you logged in for 40 consecutive days!', 'wapuugotchi' ), 'success', 100, 4, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_4' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_5', 'login_4', __( 'Consistent Conquest: The Perseverance Quest', 'wapuugotchi' ), __( 'Show your indomitable spirit in this quest, pushing the boundaries of dedication and logging in for 50 days, emerging as a champion of perseverance and a beacon of commitment in the vibrant realm of WordPress.', 'wapuugotchi' ), __( 'Nice, you logged in for 50 consecutive days!', 'wapuugotchi' ), 'success', 100, 5, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_5' ),
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
	public static function login_completed_1() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 10 ) {
			return true;
		}

		return false;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function login_completed_2() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 20 ) {
			return true;
		}

		return false;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function login_completed_3() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 30 ) {
			return true;
		}

		return false;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function login_completed_4() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 40 ) {
			return true;
		}

		return false;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function login_completed_5() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 50 ) {
			return true;
		}

		return false;
	}

	/**
	 * Count days and update in user meta.
	 *
	 * @return array|array[]|mixed
	 */
	private static function count_days() {
		$quest_meta = get_user_meta( get_current_user_id(), 'wapuugotchi_quest_meta__alpha', true );
		if ( ! is_array( $quest_meta )
			|| ! isset( $quest_meta['day_count'] )
			|| ! isset( $quest_meta['day_count']['days'] )
			|| ! isset( $quest_meta['day_count']['tstamp'] )
		) {
			$quest_meta = array(
				'day_count' => array(
					'tstamp' => 0,
					'days'   => 0,
				),
			);
		}

		if ( $quest_meta['day_count']['tstamp'] < strtotime( 'now' ) ) {
			$quest_meta['day_count']['tstamp'] = strtotime( 'tomorrow noon' );
			$quest_meta['day_count']['days']  += 1;
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_quest_meta__alpha',
				$quest_meta
			);
		}

		return $quest_meta;
	}

	/**
	 * Check if one of the given plugins is active.
	 *
	 * @param array $recommended_plugins List of recommended plugins.
	 *
	 * @return bool
	 */
	private static function is_active_plugin_in_list( $recommended_plugins ) {
		if ( ! is_array( $recommended_plugins ) ) {
			return false;
		}
		$activated_plugin = get_option( 'active_plugins' );
		$plugins          = get_plugins();

		$activated_plugin_slugs = array();
		foreach ( $activated_plugin as $p ) {
			if ( isset( $plugins[ $p ] ) ) {
				$activated_plugin_slugs[] = dirname( $p );
			}
		}

		return ! empty( array_intersect( $recommended_plugins, $activated_plugin_slugs ) );
	}
}
