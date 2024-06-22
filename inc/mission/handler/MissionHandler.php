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
	const MISSION_KEY = 'wapuugotchi_mission';

	/**
	 * Gets the current mission of the user.
	 *
	 * @return array|null The current mission or null if no mission is found.
	 */
	public static function getMissionUserData() {
		$mission = \get_user_meta( \get_current_user_id(), self::MISSION_KEY, true );

		if ( empty( $mission ) ) {
			return null;
		}

		return $mission;
	}

	/**
	 * Initializes a new mission for the user.
	 *
	 * @return array|null The new mission or null if no missions are available.
	 */
	public static function initMissionUserData() {
		$missions = self::getMissions();
		if ( empty( $missions ) ) {
			return null;
		}

		$mission = $missions[ \array_rand( $missions ) ];

		$current = array(
			'id'       => $mission->id,
			'progress' => 1,
		);

		\update_user_meta( \get_current_user_id(), self::MISSION_KEY, $current );

		return $current;
	}

	/**
	 * Gets all available missions.
	 *
	 * @return array|null The available missions or null if no missions are found.
	 */
	public static function getMissions() {
		$missions = \wp_cache_get( 'wapuugotchi_mission__missions' );

		if ( ! empty( $missions ) ) {
			return $missions;
		}

		$missions = \apply_filters( 'wapuugotchi_mission_filter', array() );

		foreach ( $missions as $key => $mission ) {
			if ( ! self::validateMission( $mission ) ) {
				unset( $missions[ $key ] );
			}
		}

		if ( empty( $missions ) ) {
			return null;
		}

		\wp_cache_set( 'wapuugotchi_mission__missions', $missions );

		return $missions;
	}

	/**
	 * Gets a mission by its ID.
	 *
	 * @param int $id The ID of the mission.
	 *
	 * @return Mission|null The mission or null if no mission is found.
	 */
	public static function getMissionById( $id ) {
		$missions = self::getMissions();

		if ( empty( $missions ) ) {
			return null;
		}

		foreach ( $missions as $mission ) {
			if ( $mission->id === $id ) {
				return $mission;
			}
		}

		return null;
	}

	/**
	 * Validates a mission.
	 *
	 * @param Mission $mission The mission to validate.
	 *
	 * @return bool True if the mission is valid, false otherwise.
	 */
	private static function validateMission( $mission ) {
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
}
