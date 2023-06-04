<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Notification {
	private $id = '';
	private $message = '';
	private $type = '';

	/**
	 * @param string $id
	 * @param string $message
	 * @param string $type
	 */
	public function __construct( $id, $message, $type ) {
		$this->id       = $id;
		$this->message  = $message;
		$this->type   = $type;
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
}
