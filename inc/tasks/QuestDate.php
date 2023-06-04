<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class QuestDate {

	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
		//add_filter('admin_init', array($this, 'add_wapuugotchi_filter'));

	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_1', null, 'Log in on 10 different days', 'Nice, you logged in for 10 consecutive days!', 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_1' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_2', 'login_1', 'Log in on 20 different days', 'Nice, you logged in for 20 consecutive days!', 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_2' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_3', 'login_2', 'Log in on 30 different days', 'Nice, you logged in for 30 consecutive days!', 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_3' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_4', 'login_3', 'Log in on 40 different days', 'Nice, you logged in for 40 consecutive days!', 'success', 100, 4, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_4' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'login_5', 'login_4', 'Log in on 50 different days', 'Nice, you logged in for 50 consecutive days!', 'success', 100, 5, 'Wapuugotchi\Wapuugotchi\QuestDate::always_true', 'Wapuugotchi\Wapuugotchi\QuestDate::login_completed_5' ),
		);

		return array_merge( $default_quest, $quests );
	}

	//Posts
	public static function always_true() {
		return true;
	}

	public static function login_completed_1() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 10 ) {
			return true;
		}

		return false;
	}

	public static function login_completed_2() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 20 ) {
			return true;
		}

		return false;
	}

	public static function login_completed_3() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 30 ) {
			return true;
		}

		return false;
	}

	public static function login_completed_4() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 40 ) {
			return true;
		}

		return false;
	}

	public static function login_completed_5() {
		$quest_meta = self::count_days();
		if ( $quest_meta['day_count']['days'] >= 50 ) {
			return true;
		}

		return false;
	}


	private static function count_days() {
		$quest_meta = get_user_meta( get_current_user_id(), 'wapuugotchi_quest_meta__alpha', true );
		if ( ! is_array( $quest_meta ) ||
			 ! isset( $quest_meta['day_count'] ) ||
			 ! isset( $quest_meta['day_count']['days'] ) ||
			 ! isset( $quest_meta['day_count']['tstamp'] )
		) {
			$quest_meta = array(
				'day_count' => array(
					'tstamp' => 0,
					'days'  => 0,
				),
			);
		}

		if ( $quest_meta['day_count']['tstamp'] < strtotime( 'now' ) ) {
			$quest_meta['day_count']['tstamp'] = strtotime( 'tomorrow noon' );
			$quest_meta['day_count']['days']   += 1;
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_quest_meta__alpha',
				$quest_meta
			);
		}

		return $quest_meta;
	}


	//helper
	private static function is_active_plugin_in_list( $list ) {
		if ( ! is_array( $list ) ) {
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

		return ! empty( array_intersect( $list, $activated_plugin_slugs ) );
	}
}
