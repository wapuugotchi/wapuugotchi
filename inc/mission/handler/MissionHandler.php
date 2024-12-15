<?php
/**
 * The MissionHandler Class.
 *
 * This class is responsible for handling the missions in the WapuuGotchi game.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission\Handler;

use Wapuugotchi\Mission\Models\Mission;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class MissionHandler
 *
 * Handles the missions in the WapuuGotchi game.
 */
class MissionHandler {
	/**
	 * The key used to store mission data in user meta.
	 */
	const MISSION_KEY = 'wapuugotchi_mission';

	/**
	 * Validates the user data for a mission.
	 *
	 * @param array $user_data The user data to validate.
	 *
	 * @return bool True if the user data is valid, false otherwise.
	 */
	public static function validate_user_data( $user_data ) {
		if ( empty( $user_data ) || empty( $user_data['id'] ) ) {
			return false;
		}

		$mission = self::get_mission_by_id( $user_data['id'] );
		if ( empty( $mission ) ) {
			return false;
		}

		if ( ! \is_array( $user_data['actions'] ) ) {
			return false;
		}

		if ( \count( $user_data['actions'] ) !== \count( $mission->markers ) ) {
			return false;
		}

		if ( (int) $user_data['progress'] >= \count( $mission->markers ) ) {
			return false;
		}

		return true;
	}

	/**
	 * Retrieves the mission data for the current user.
	 *
	 * @return array|null The mission data for the current user, or null if no mission data is found.
	 */
	public static function get_user_data() {
		$mission = \get_user_meta( \get_current_user_id(), self::MISSION_KEY, true );
		return ! empty( $mission ) ? $mission : null;
	}

	/**
	 * Initializes a new mission for the current user.
	 *
	 * @return array|null The data for the new mission, or null if no missions are available.
	 */
	public static function init_mission() {
		$missions = self::get_all_missions();
		if ( ! empty( $missions ) ) {
			$mission       = $missions[ \array_rand( $missions ) ];
			$actions       = array();
			$markers_count = \count( $mission->markers );
			for ( $i = 0; $i < $markers_count; $i++ ) {
				$action = ActionHandler::get_random_action();
				if ( empty( $action ) ) {
					continue;
				}
				$actions[] = $action['id'];
			}

			$current = array(
				'id'       => $mission->id,
				'progress' => 0,
				'actions'  => $actions,
				'date'     => 0,
			);

			\update_user_meta( \get_current_user_id(), self::MISSION_KEY, $current );

			return $current;
		}

		return null;
	}

	/**
	 * Retrieves all available missions.
	 *
	 * @return array|null An array of all available missions, or null if no missions are found.
	 */
	private static function get_all_missions() {
		$missions = \wp_cache_get( 'wapuugotchi_mission__missions' );
		if ( ! empty( $missions ) ) {
			return $missions;
		}

		$missions = \apply_filters( 'wapuugotchi_mission_filter', array() );
		$missions = \array_filter(
			$missions,
			function ( $mission ) {
				return self::validate_mission( $mission );
			}
		);

		if ( isset( $missions ) ) {
			\wp_cache_set( 'wapuugotchi_mission__missions', $missions );

			return $missions;
		}

		return null;
	}

	/**
	 * Retrieves a mission by its ID.
	 *
	 * @param string $id The ID of the mission to retrieve.
	 *
	 * @return Mission|null The mission with the given ID, or null if no such mission is found.
	 */
	public static function get_mission_by_id( $id ) {
		$missions = self::get_all_missions();
		if ( \is_array( $missions ) ) {
			foreach ( $missions as $mission ) {
				if ( $mission->id === $id ) {
					return $mission;
				}
			}
		}

		return null;
	}

	/**
	 * Validates a mission.
	 *
	 * @param mixed $mission The mission to validate.
	 *
	 * @return bool True if the mission is valid, false otherwise.
	 */
	private static function validate_mission( $mission ) {
		if ( ! $mission instanceof Mission ) {
			return false;
		}

		if ( empty( $mission->id )
			|| empty( $mission->name )
			|| empty( $mission->description )
			|| empty( $mission->url )
			|| \count( $mission->markers ) < 1
			|| $mission->reward < 1
		) {
			return false;
		}

		return true;
	}

	/**
	 * Raises the mission step for the current user.
	 *
	 * @return bool True if the mission step was raised, false otherwise.
	 * @throws \Exception If the current date cannot be retrieved.
	 */
	public static function raise_mission_step() {
		$mission_data = self::get_user_data();
		if ( empty( $mission_data ) || empty( $mission_data['id'] ) ) {
			$mission_data = self::init_mission();
		}

		if ( ! isset( $mission_data['progress'] ) ) {
			return false;
		}

		$timezone      = new \DateTimeZone( \wp_timezone_string() );
		$now_date_time = new \DateTime( 'now', $timezone );

		if ( $now_date_time->getTimestamp() < $mission_data['date'] ) {
			return false;
		}
		$midnight_date_time       = new \DateTime( 'tomorrow midnight', $timezone );
		$mission_data['date']     = $midnight_date_time->getTimestamp();
		$mission_data['progress'] = (int) $mission_data['progress'] + 1;

		\update_user_meta( \get_current_user_id(), self::MISSION_KEY, $mission_data );

		return true;
	}

	/**
	 * Checks if the current mission is locked.
	 *
	 * @param array $user_data The user data for the current mission.
	 *
	 * @return bool True if the mission is locked, false otherwise.
	 * @throws \Exception If the current date cannot be retrieved.
	 */
	public static function is_mission_locked( $user_data ) {
		if ( empty( $user_data ) ) {
			return false;
		}
		$timezone = new \DateTimeZone( \wp_timezone_string() );
		$now      = new \DateTime( 'now', $timezone );
		$locked   = $now->getTimestamp() < (int) $user_data['date'];
		return empty( $user_data['actions'] ) ? true : $locked;
	}
}
