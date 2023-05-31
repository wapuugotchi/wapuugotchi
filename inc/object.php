<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Quest {
	private $id = '';
	private $parent_id = '';
	private $title = '';
	private $message = '';
	private $priority = '';
	private $pearls = '';
	private $active_callback = '';
	private $completed_callback = '';

	/**
	 * @param string $id
	 * @param string $parent_id
	 * @param string $title
	 * @param string $message
	 * @param string $priority
	 * @param string $pearls
	 * @param string $active_callback
	 * @param string $completed_callback
	 */
	public function __construct( $id, $parent_id, $title, $message, $priority, $pearls, $active_callback, $completed_callback ) {
		$this->id                 = $id;
		$this->parent_id          = $parent_id;
		$this->title              = $title;
		$this->message            = $message;
		$this->priority           = $priority;
		$this->pearls             = $pearls;
		$this->active_callback    = $active_callback;
		$this->completed_callback = $completed_callback;
	}

	/**
	 * @return string
	 */
	public function getId() {
		return $this->id;
	}

	/**
	 * @return string
	 */
	public function getParentId() {
		return $this->parent_id;
	}

	/**
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * @return string
	 */
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return string
	 */
	public function getPriority() {
		return $this->priority;
	}

	/**
	 * @return string
	 */
	public function getPearls() {
		return $this->pearls;
	}

	/**
	 * @return string
	 */
	public function isActive() {
		if ( is_callable( $this->active_callback ) ) {
			$result = call_user_func( $this->active_callback );

			if ( is_bool( $result ) ) {
				return $result;
			}
		}

		return false;
	}

	/**
	 * @return string
	 */
	public function isCompleted() {
		if ( is_callable( $this->completed_callback ) ) {
			$result = call_user_func( $this->completed_callback );

			if ( is_bool( $result ) ) {
				return $result;
			}
		}

		return false;
	}


}
