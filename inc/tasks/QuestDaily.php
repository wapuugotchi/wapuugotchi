<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class QuestDaily {
	const ID_COLLECTION = array( 'origin_daily_login_1', 'origin_daily_login_2' );

	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
		//add_filter('admin_init', array($this, 'add_wapuugotchi_filter'));

	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'origin_daily_login_1', 'first_start_1', __('Du hast dich heute angemeldet.', 'wapuugotchi' ), self::get_random_welcome_phrase(), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestDaily::always_true', 'Wapuugotchi\Wapuugotchi\QuestDaily::origin_daily_login_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'origin_daily_login_2', 'origin_daily_login_1', __('Du hast dich heute angemeldet.', 'wapuugotchi' ), self::get_random_welcome_phrase(), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestDaily::always_true', 'Wapuugotchi\Wapuugotchi\QuestDaily::origin_daily_login_completed' ),
		);

		return array_merge( $default_quest, $quests );
	}

	//Posts
	public static function always_true() {
		return true;
	}

	public static function origin_daily_login_completed() {
		$quest_meta = get_user_meta( get_current_user_id(), 'wapuugotchi_quest_meta__alpha', true );
		if ( ! is_array( $quest_meta ) || ! isset( $quest_meta['origin_daily_login'] ) ) {
			/** just init quest_meta for origin_daily_login-quest */
			$quest_meta['origin_daily_login'] = 0;
			update_user_meta( get_current_user_id(), 'wapuugotchi_quest_meta__alpha', $quest_meta );
		}
		if ( $quest_meta['origin_daily_login'] < Helper::get_timestamp_for_today() ) {
			/** remove all complete origin_daily_login-quests for make possible an quest rotation */
			$new_completed_quests = array();
			$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true );
			$diff = array_diff( array_keys( $completed_quests), self::ID_COLLECTION);
			foreach ( $diff as $id ) {
				if( isset( $completed_quests [$id] ) ) {
					$new_completed_quests[$id] = $completed_quests [$id];
				}
			}
			update_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', $new_completed_quests );

			/** set new timestamp for tomorrow */
			$quest_meta['origin_daily_login'] = Helper::get_timestamp_for_tomorrow();
			update_user_meta( get_current_user_id(), 'wapuugotchi_quest_meta__alpha', $quest_meta );

			return true;
		}

		return false;
	}

	private static function get_random_welcome_phrase() {
		$user_data = wp_get_current_user();
		$name =  $user_data->first_name ? $user_data->first_name : $user_data->display_name;
		$phrases = array(
			'Nice to have you back! &#x1F44A;',
			'Great to see you! &#128079;',
			'Let`s start! &#x1F4AA;',
			'You`re back ' . $name . '! &#129505;',
			'You are finally back! &#128571;',
			$name . ', I was already worried about you ... &#129402;&#128148;',
			'Hello ' . $name . '! &#128536;',
			$name . '!!! &#128525;',
			'Welcome back ' . $name . '! &#128525;'
		);

		return $phrases[array_rand( $phrases, 1)];
	}
}
