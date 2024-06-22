<?php
/**
 * The MissionHandler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Handles the mission map related tasks
 */
class MapHandler {
	public static function getRandomMap() {

	}

	/**
	 * Get the current map. If no map is set, return a random map.
	 * @return void
	 */
	public static function getMapById( $id ) {
		$mission = MissionHandler::getMissionById( $id );
		if ( empty( $mission ) ) {
			return null;
		}

		$map = $mission->url;
		if ( empty( $map ) ) {
			return null;
		}

		if ( ! self::validateMapByUrl( $map ) ) {
			return null;
		}

		return $map;
	}

	private static function validateMapByUrl( $url ) {
		if ( empty( $url ) ) {
			return false;
		}

		if ( ! \filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return false;
		}

		$response = wp_remote_get($url);
		if (is_wp_error($response)) {
			return false;
		}

		$body = wp_remote_retrieve_body($response);
		if (strpos($body, '<svg') === false || strpos($body, '</svg>') === false) {
			return false;
		}

		return true;
	}
}
