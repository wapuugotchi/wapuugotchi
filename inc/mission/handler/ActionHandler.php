<?php
/**
 * The ActionHandler Class.
 *
 * This class is responsible for handling the actions in the WapuuGotchi game.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class ActionHandler
 *
 * Handles all actions and games registered for missions.
 */
class ActionHandler {
	/**
	 * Retrieves a random action from the list of all actions.
	 *
	 * @return array|null The data for the random action, or null if no actions are available.
	 */
	public static function get_random_action() {
		$actions = self::get_all_actions();
		if ( ! is_array( $actions ) || empty( $actions ) ) {
			return null;
		}

		$action = $actions[ \array_rand( $actions ) ];

		if ( ! self::is_valid_action( $action ) ) {
			return self::get_random_action();
		}

		return $action;
	}

	/**
	 * Retrieves all available actions.
	 *
	 * @return array|null An array of all available actions, or null if no actions are found.
	 */
	public static function get_all_actions() {
		$actions = \wp_cache_get( 'wapuugotchi_mission__actions' );
		if ( ! empty( $actions ) ) {
			return $actions;
		}

		$actions = \apply_filters( 'wapuugotchi_register_action__filter', array() );
		if ( empty( $actions ) ) {
			return null;
		}

		\wp_cache_set( 'wapuugotchi_mission__actions', $actions );

		return $actions;
	}

	/**
	 * Validates an action.
	 *
	 * @param mixed $action The action to validate.
	 *
	 * @return bool True if the action is valid, false otherwise.
	 */
	public static function is_valid_action( $action ) {
		if ( empty( $action['id'] ) || empty( $action['name'] ) || empty( $action['description'] ) ) {
			return false;
		}

		return true;
	}
}
