<?php
/**
 * The Mission Class.
 *
 * This class represents a mission in the WapuuGotchi game. Each mission has an id, name, description, url, markers, and reward.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Mission
 *
 * Represents a mission in the WapuuGotchi game.
 */
class Mission {
	/**
	 * The ID of the mission.
	 *
	 * @var string
	 */
	public $id = '';

	/**
	 * The name of the mission.
	 *
	 * @var string
	 */
	public $name = '';

	/**
	 * The description of the mission.
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * The URL of the mission.
	 *
	 * @var string
	 */
	public $url = '';

	/**
	 * The markers of the mission.
	 *
	 * @var string
	 */
	public $markers = 0;

	/**
	 * The reward of the mission.
	 *
	 * @var string
	 */
	public $reward = 0;

	/**
	 * Creates a new instance of the Mission class.
	 *
	 * @return Mission The new instance of the Mission class.
	 */
	public static function create() {
		return new Mission();
	}

	/**
	 * Sets the ID of the mission.
	 *
	 * @param string $id The ID of the mission.
	 * @return Mission The instance of the Mission class.
	 */
	public function set_id( $id ) {
		$this->id = $id;

		return $this;
	}

	/**
	 * Sets the name of the mission.
	 *
	 * @param string $name The name of the mission.
	 * @return Mission The instance of the Mission class.
	 */
	public function set_name( $name ) {
		$this->name = $name;

		return $this;
	}

	/**
	 * Sets the description of the mission.
	 *
	 * @param string $description The description of the mission.
	 * @return Mission The instance of the Mission class.
	 */
	public function set_description( $description ) {
		$this->description = $description;

		return $this;
	}

	/**
	 * Sets the URL of the mission.
	 *
	 * @param string $url The URL of the mission.
	 * @return Mission The instance of the Mission class.
	 */
	public function set_url( $url ) {
		$this->url = $url;

		return $this;
	}

	/**
	 * Sets the markers of the mission.
	 *
	 * @param integer $markers The markers of the mission.
	 * @return Mission The instance of the Mission class.
	 */
	public function set_markers( $markers ) {
		$this->markers = $markers;

		return $this;
	}

	/**
	 * Sets the reward of the mission.
	 *
	 * @param integer $reward The reward of the mission.
	 * @return Mission The instance of the Mission class.
	 */
	public function set_reward( $reward ) {
		$this->reward = $reward;

		return $this;
	}
}
