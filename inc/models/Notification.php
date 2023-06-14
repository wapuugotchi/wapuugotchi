<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Notification {
	private $id = '';
	private $message = '';
	private $type = '';
	private $remember = '';

	/**
	 * @param string $id
	 * @param string $message
	 * @param string $type
	 * @param string $remember
	 */
	public function __construct( $id, $message, $type, $remember) {
		$this->id       = $id;
		$this->message  = $message;
		$this->type     = $type;
		$this->remember = $remember;
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
	public function getMessage() {
		return $this->message;
	}

	/**
	 * @return string
	 */
	public function getType() {
		return $this->type;
	}

	/**
	 * If the issue is still relevant, the message should be resent after x days.
	 * @return string
	 */
	public function getRemember() {
		return $this->remember;
	}
}
