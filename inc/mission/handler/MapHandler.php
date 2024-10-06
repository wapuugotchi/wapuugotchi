<?php
/**
 * The MapHandler Class.
 *
 * This class is responsible for handling the map related tasks in the WapuuGotchi game.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class MapHandler
 *
 * Handles the mission map related tasks.
 */
class MapHandler {
	/**
	 * Retrieves a map by its ID.
	 *
	 * @param string $id The ID of the map to retrieve.
	 *
	 * @return string|null The URL of the map with the given ID, or null if no such map is found.
	 */
	private static function get_map_by_id( $id ) {
		$mission = MissionHandler::get_mission_by_id( $id );
		if ( ! isset( $mission ) ) {
			return null;
		}

		$map = $mission->url;
		if ( ! isset( $map ) ) {
			return null;
		}

		if ( ! self::validate_map_by_url( $map ) ) {
			return null;
		}

		return $map;
	}

	/**
	 * Retrieves the SVG of a map by its ID.
	 *
	 * @param string $id The ID of the map to retrieve.
	 *
	 * @return string|null The SVG of the map with the given ID, or null if no such map is found.
	 */
	public static function get_map_svg_by_id( $id ) {
		$map = self::get_map_by_id( $id );
		if ( ! isset( $map ) ) {
			return null;
		}

		$response = wp_remote_get( $map );
		if ( is_wp_error( $response ) ) {
			return null;
		}

		$body = wp_remote_retrieve_body( $response );
		if ( strpos( $body, '<svg' ) === false || strpos( $body, '</svg>' ) === false ) {
			return null;
		}

		return $body;
	}
	/**
	 * Validates a map by its URL.
	 *
	 * @param string $url The URL of the map to validate.
	 *
	 * @return bool True if the map is valid, false otherwise.
	 */
	private static function validate_map_by_url( $url ) {
		if ( ! isset( $url ) ) {
			return false;
		}

		if ( ! \filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return false;
		}

		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );
		if ( strpos( $body, '<svg' ) === false || strpos( $body, '</svg>' ) === false ) {
			return false;
		}

		return true;
	}
}
