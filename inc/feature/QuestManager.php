<?php
/**
 * The Quest Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestManager
 */
class QuestManager {


	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ), 20, 0 );
	}

	/**
	 * Initialization QuestManager
	 *
	 * @return void
	 */
	public function init() {
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true ) ) ) {
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_completed_quests__alpha',
				array()
			);
		}

		$completed_quests = $this->check_quest_progress();
		$this->update_completed_quests( $completed_quests );
		$this->add_pearls( $completed_quests );
	}

	/**
	 * Get all quests submitted using the filter.
	 *
	 * @return bool|mixed|null
	 */
	public static function get_all_quests() {
		/*
		$quest = wp_cache_get( 'wapuugotchi_quests' );

		if ( ! empty( $quest ) ) {
			return $quest;
		}
		*/

		$quest = apply_filters( 'wapuugotchi_quest_filter', array() );

		wp_cache_set( 'wapuugotchi_quests', $quest );

		return $quest;
	}

	/**
	 * Get all active quests. Already completed and not yet available (due to dependencies) are not included.
	 *
	 * @return array
	 */
	public static function get_active_quests() {
		$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true );
		$all_quests       = self::get_all_quests();
		$result_array     = array();

		if ( empty( wp_cache_get( 'wapuugotchi_quests' ) ) || ! is_array( $completed_quests ) ) {
			return array();
		}
		foreach ( $all_quests as $value ) {
			if ( in_array( $value->get_id(), array_keys( $completed_quests ), true ) ) {
				continue;
			}
			if ( ! $value->is_active() ) {
				continue;
			}

			if ( $value->get_parent_id() === null || in_array( $value->get_parent_id(), array_keys( $completed_quests ), true ) ) {
				$result_array [] = $value;
			}
		}

		return $result_array;
	}

	/**
	 * Get all quests that the current user has already completed.
	 *
	 * @return mixed
	 */
	public static function get_completed_quests() {
		return get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true );
	}

	/**
	 * Check all active quests if they have already been completed.
	 *
	 * @return array
	 */
	private function check_quest_progress() {
		$active_quests = self::get_active_quests();
		$result        = array();

		foreach ( $active_quests as $quest ) {
			if ( $quest->is_completed() ) {
				$result[ $quest->get_id() ] = $quest;
			}
		}

		return $result;
	}

	/**
	 * Complete completed quests.
	 *
	 * @param array $quests all quests.
	 *
	 * @return void
	 */
	private function update_completed_quests( $quests ) {
		$completed_quests     = get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true );
		$new_completed_quests = array();

		if ( ! empty( $quests ) ) {
			foreach ( $quests as $index => $quest ) {
				$new_completed_quests[ $quest->get_id() ] = array(
					'id'       => $quest->get_id(),
					'date'     => gmdate( 'j F, Y \@ g:ia' ),
					'notified' => false,
				);

			}

			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_completed_quests__alpha',
				array_unique( array_merge( $completed_quests, $new_completed_quests ), SORT_REGULAR )
			);
		}
	}

	/**
	 * Deposits pearls to the user's balance, according to the quest.
	 *
	 * @param array $quests all quests.
	 *
	 * @return void
	 */
	private function add_pearls( $quests ) {
		$pearls = 0;

		foreach ( $quests as $quest ) {
			$pearls += $quest->get_pearls();
		}

		if ( $pearls > 0 ) {
			$balance  = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ) );
			$balance += $pearls;
			update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', $balance );
		}
	}
}
