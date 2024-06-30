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


	public static function get_mission() {
		// The user data of the current mission!
		$mission_data = self::get_mission_user_data();
		if ( empty( $mission_data ) || empty( $mission_data['id'] ) ) {
			$mission_data = self::init_new_mission();
			if ( empty( $mission_data ) ) {
				return false;
			}
		}

		// The mission data!
		$mission = self::get_mission_by_id( $mission_data['id'] );
		if ( empty( $mission ) ) {
			return false;
		}

		// Check if the mission is completed!
		if( (int)$mission_data['progress'] >= $mission->markers ) {
			$timezone = new \DateTimeZone( \wp_timezone_string() );
			$now = new \DateTime( 'now', $timezone );
			if ( $now->getTimestamp() > (int) $mission_data['date'] ) {
				return self::init_new_mission();
			}
		}

		return $mission_data;
	}

	/**
	 * Retrieves the mission data for the current user.
	 *
	 * @return array|null The mission data for the current user, or null if no mission data is found.
	 */
	public static function get_mission_user_data() {
		$mission = \get_user_meta( \get_current_user_id(), self::MISSION_KEY, true );

		if ( isset( $mission ) ) {
			return $mission;
		}

		return null;
	}

	/**
	 * Initializes a new mission for the current user.
	 *
	 * @return array|null The data for the new mission, or null if no missions are available.
	 */
	public static function init_new_mission() {
		$missions = self::get_missions();
		if ( isset( $missions ) ) {
			$mission = $missions[ \array_rand( $missions ) ];

			$actions = array();
			for ( $i = 0; $i < $mission->markers; $i++ ) {
				$action    = ActionHandler::get_random_action();
				if ( empty( $action ) ) {
					continue;
				}
				$actions[] = $action['id'];
			}

			$current = array(
				'id'       => $mission->id,
				'progress' => 0,
				'actions'  => $actions,
				'date'     => 0
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
	private static function get_missions() {
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
		$missions = self::get_missions();
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
			|| $mission->markers < 1
			|| $mission->reward < 1
		) {
			return false;
		}

		return true;
	}

	public static function raise_mission_step() {
		$mission_data = self::get_mission_user_data();
		if ( empty( $mission_data ) || empty( $mission_data['id'] ) ) {
			$mission_data = self::init_new_mission();
		}

		if ( ! isset( $mission_data['progress'] ) ) {
			return;
		}

		$timezone = new \DateTimeZone( \wp_timezone_string() );

		$midnight_date_time = new \DateTime( 'tomorrow midnight', $timezone );

		$mission_data['date'] = (int) $midnight_date_time->getTimestamp();
		$mission_data['progress'] = (int) $mission_data['progress'] + 1;

		\update_user_meta( \get_current_user_id(), self::MISSION_KEY, $mission_data );
	}
}
