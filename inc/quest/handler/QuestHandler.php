<?php
/**
 * The Api Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Handler;

use Wapuugotchi\Shop\Handler\BalanceHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestHandler
 */
class QuestHandler {


	/**
	 * Get active quests.
	 *
	 * @return array
	 */
	public static function get_active_quests() {
		$active_quests = self::find_active_quests();
		$result        = array();

		foreach ( $active_quests as $active_quest ) {
			$result[] = array(
				'title'  => $active_quest->get_title(),
				'pearls' => $active_quest->get_pearls(),
			);
		}

		return $result;
	}

	/**
	 * Find active quests.
	 *
	 * @return array
	 */
	private static function find_active_quests() {
		$completed_quests = \get_user_meta( \get_current_user_id(), 'wapuugotchi_quest_completed', true );
		$all_quests       = self::get_all_quests();
		$active_quests    = array();

		if ( ! \is_array( $completed_quests ) ) {
			$completed_quests = array();
		}

		foreach ( $all_quests as $quest ) {
			if ( \in_array( $quest->get_id(), \array_keys( $completed_quests ), true ) ) {
				continue;
			}

			if ( $quest->get_parent_id() !== null && ! \in_array( $quest->get_parent_id(), \array_keys( $completed_quests ), true ) ) {
				continue;
			}

			if ( ! $quest->is_active() ) {
				continue;
			}

			$active_quests [] = $quest;
		}

		return $active_quests;
	}

	/**
	 * Get all quests.
	 *
	 * @return array
	 */
	public static function get_all_quests() {
		$quest = \wp_cache_get( 'wapuugotchi_all_quests' );

		if ( ! empty( $quest ) ) {
			return $quest;
		}

		$quest = \apply_filters( 'wapuugotchi_quest_filter', array() );

		\wp_cache_set( 'wapuugotchi_all_quests', $quest );

		return $quest;
	}

	/**
	 * Get all completed quests.
	 *
	 * @return array
	 */
	public static function get_completed_quests() {
		$result           = array();
		$all_quests       = self::get_all_quests();
		$completed_quests = \get_user_meta( \get_current_user_id(), 'wapuugotchi_quest_completed', true );
		if ( ! \is_array( $completed_quests ) ) {
			return array();
		}

		foreach ( $completed_quests as $completed_quest_key => $completed_quest ) {
			foreach ( $all_quests as $quest ) {
				if ( $completed_quest_key === $quest->get_id() ) {
					$result[ $quest->get_id() ] = array(
						'title'    => $quest->get_title(),
						'pearls'   => $quest->get_pearls(),
						'date'     => $completed_quest['date'],
						'notified' => $completed_quest['notified'],
					);

					break;
				}
			}
		}

		return $result;
	}

	/**
	 * Manage Quest Progress.
	 *
	 * @return void
	 */
	public static function manage_quest_progress() {
		$completed_quests = self::check_quest_progress();
		foreach ( $completed_quests as $completed_quest ) {
			$update_state = self::set_quest_completed( $completed_quest->get_id() );
			if ( ! $update_state ) {
				continue;
			}
			BalanceHandler::increase_balance( $completed_quest->get_pearls() );
		}
	}

	/**
	 * Check Quest Progress.
	 *
	 * @return array
	 */
	private static function check_quest_progress() {
		$active_quests = self::find_active_quests();
		$result        = array();

		foreach ( $active_quests as $quest ) {
			if ( $quest->is_completed() ) {
				$result[ $quest->get_id() ] = $quest;
			}
		}

		return $result;
	}

	/**
	 * Set Quest as completed.
	 *
	 * @param string $quest_id The ID of the quest.
	 *
	 * @return bool
	 */
	private static function set_quest_completed( $quest_id ) {
		$completed_quests     = \get_user_meta( \get_current_user_id(), 'wapuugotchi_quest_completed', true );
		$new_completed_quests = array();
		if ( ! \is_array( $completed_quests ) ) {
			$completed_quests = array();
		}

		$active_quests   = self::find_active_quests();
		$quest_is_active = false;
		foreach ( $active_quests as $active_quest ) {
			if ( $active_quest->get_id() === $quest_id ) {
				$quest_is_active = true;
				break;
			}
		}
		if ( ! $quest_is_active ) {
			return false;
		}

		$new_completed_quests[ $quest_id ] = array(
			'date'     => \gmdate( 'j F, Y \@ g:ia' ),
			'notified' => false,
		);

		\update_user_meta(
			\get_current_user_id(),
			'wapuugotchi_quest_completed',
			\array_merge_recursive( $completed_quests, $new_completed_quests )
		);

		return true;
	}

	/**
	 * Get Quest by ID.
	 *
	 * @param string $id The ID of the quest.
	 *
	 * @return Quest|null
	 */
	public static function get_quest_by_id( $id ) {
		$all_quests = self::get_all_quests();
		foreach ( $all_quests as $quest ) {
			if ( $quest->get_id() === $id ) {
				return $quest;
			}
		}

		return null;
	}
}
