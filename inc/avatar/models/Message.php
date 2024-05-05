<?php
/**
 * The Message object class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Quest
 */
class Message {

	/**
	 * ID of the quest.
	 *
	 * @var string
	 */
	private $id = '';
	/**
	 * Message that is displayed when the quest is completed.
	 *
	 * @var string
	 */
	private $message = '';
	/**
	 * Type of the quest ( info, success, error, warning ).
	 *
	 * @var string
	 */
	private $type = '';
	/**
	 * Callback function to be called to check if the message is active.
	 *
	 * @var string
	 */
	private $is_active = '';
	/**
	 * Callback function to be called to check if the message is submitted.
	 *
	 * @var string
	 */
	private $handle_submit = '';

	/**
	 * "Constructor" of this class
	 *
	 * @param string $id The ID.
	 * @param string $message The message.
	 * @param string $type The border color.
	 * @param string $is_active The active state.
	 * @param string $handle_submit The completed state.
	 */
	public function __construct( $id, $message, $type, $is_active, $handle_submit ) {
		$this->id            = $id;
		$this->message       = $message;
		$this->type          = $type;
		$this->is_active     = $is_active;
		$this->handle_submit = $handle_submit;
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
	 * Get is active.
	 *
	 * @return string
	 */
	public function is_active() {
		if ( is_callable( $this->is_active ) ) {
			$result = call_user_func( $this->is_active );

			if ( is_bool( $result ) ) {
				return $result;
			}
		}

		return false;
	}

	/**
	 * What is happening when the message is submitted.
	 * The callback is executed by the submit_message function in the Api class.
	 *
	 * @return bool result of the callback.
	 */
	public function dismiss() {
		if ( is_callable( $this->handle_submit ) ) {
			return $this->handle_submit;
		}

		return false;
	}
}
