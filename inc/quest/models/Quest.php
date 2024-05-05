<?php
/**
 * The Quest Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Quest
 */
class Quest {

	/**
	 * ID of the quest.
	 *
	 * @var string
	 */
	private $id = '';
	/**
	 * The parent ID of this quest.
	 *
	 * @var string
	 */
	private $parent_id = '';
	/**
	 * Title of the Quest.
	 *
	 * @var string
	 */
	private $title = '';
	/**
	 * Message that is displayed when the quest is completed.
	 *
	 * @var string
	 */
	private $message = '';
	/**
	 * The priority of the quest.
	 *
	 * @var string
	 */
	private $priority = '';
	/**
	 * Type of the quest ( info, success, error, warning ).
	 *
	 * @var string
	 */
	private $type = '';
	/**
	 * Number of pearls credited to the user after completing the quest.
	 *
	 * @var string
	 */
	private $pearls = '';
	/**
	 * Callback function to be called to check if the quest is active.
	 *
	 * @var string
	 */
	private $active_callback = '';
	/**
	 * Callback function to be called to check if the quest is completed.
	 *
	 * @var string
	 */
	private $completed_callback = '';

	/**
	 * "Constructor" of this class
	 *
	 * @param string $id The ID.
	 * @param string $parent_id The parent ID.
	 * @param string $title The title.
	 * @param string $message The message.
	 * @param string $type The type.
	 * @param string $priority The priority.
	 * @param string $pearls The pearls.
	 * @param string $active_callback The active state.
	 * @param string $completed_callback The completed state.
	 */
	public function __construct( $id, $parent_id, $title, $message, $type, $priority, $pearls, $active_callback, $completed_callback ) {
		$this->id                 = $id;
		$this->parent_id          = $parent_id;
		$this->title              = $title;
		$this->message            = $message;
		$this->type               = $type;
		$this->priority           = $priority;
		$this->pearls             = $pearls;
		$this->active_callback    = $active_callback;
		$this->completed_callback = $completed_callback;
	}

	/**
	 * Get ID.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get parent ID.
	 *
	 * @return string
	 */
	public function get_parent_id() {
		return $this->parent_id;
	}

	/**
	 * Get title.
	 *
	 * @return string
	 */
	public function get_title() {
		return $this->title;
	}

	/**
	 * Get message.
	 *
	 * @return string
	 */
	public function get_message() {
		return $this->message;
	}

	/**
	 * Get type.
	 *
	 * @return string
	 */
	public function get_type() {
		return $this->type;
	}

	/**
	 * Get priority.
	 *
	 * @return string
	 */
	public function get_priority() {
		return $this->priority;
	}

	/**
	 * Get pearls.
	 *
	 * @return string
	 */
	public function get_pearls() {
		return $this->pearls;
	}

	/**
	 * Get is active.
	 *
	 * @return string
	 */
	public function is_active() {
		if ( is_callable( $this->active_callback ) ) {
			$result = call_user_func( $this->active_callback );

			if ( is_bool( $result ) ) {
				return $result;
			}
		}

		return false;
	}

	/**
	 * Get is completed.
	 *
	 * @return string
	 */
	public function is_completed() {
		if ( is_callable( $this->completed_callback ) ) {
			$result = call_user_func( $this->completed_callback );

			if ( is_bool( $result ) ) {
				return $result;
			}
		}

		return false;
	}
}
