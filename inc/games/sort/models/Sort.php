<?php
/**
 * The Sort Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Sort\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Sort
 */
class Sort {

	/**
	 * ID of the sort.
	 *
	 * @var string
	 */
	private $id = '';

	/**
	 * Question of the sort.
	 *
	 * @var string
	 */
	private $question = '';

	/**
	 * Items of the sort (in correct order).
	 *
	 * @var array
	 */
	private $items = array();

	/**
	 * Notice of the correct answer.
	 *
	 * @var string
	 */
	private $correct_notice = '';

	/**
	 * Notice of the wrong answer.
	 *
	 * @var string
	 */
	private $incorrect_notice = '';

	/**
	 * Distractor item that does not belong in the correct order.
	 *
	 * @var string
	 */
	private $distractor = '';

	/**
	 * "Constructor" of this Class
	 *
	 * @param string $id ID of the sort.
	 * @param string $question Question of the sort.
	 * @param array  $items Items in correct order.
	 * @param string $correct_notice Notice of the correct answer.
	 * @param string $incorrect_notice Notice of the wrong answer.
	 * @param string $distractor Distractor item that does not belong in the correct order.
	 */
	public function __construct( $id, $question, $items, $correct_notice, $incorrect_notice, $distractor ) {
		$this->id               = $id;
		$this->question         = $question;
		$this->items            = $items;
		$this->correct_notice   = $correct_notice;
		$this->incorrect_notice = $incorrect_notice;
		$this->distractor       = $distractor;
	}

	/**
	 * Get the ID of the sort.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Set the ID of the sort.
	 *
	 * @param string $id ID of the sort.
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Get the question of the sort.
	 *
	 * @return string
	 */
	public function get_question() {
		return $this->question;
	}

	/**
	 * Set the question of the sort.
	 *
	 * @param string $question Question of the sort.
	 */
	public function set_question( $question ) {
		$this->question = $question;
	}

	/**
	 * Get the items of the sort.
	 *
	 * @return array
	 */
	public function get_items(): array {
		return $this->items;
	}

	/**
	 * Set the items of the sort.
	 *
	 * @param array $items Items in correct order.
	 */
	public function set_items( array $items ) {
		$this->items = $items;
	}

	/**
	 * Get the notice of the correct answer.
	 *
	 * @return string
	 */
	public function get_correct_notice() {
		return $this->correct_notice;
	}

	/**
	 * Set the notice of the correct answer.
	 *
	 * @param string $correct_notice Notice of the correct answer.
	 */
	public function set_correct_notice( $correct_notice ) {
		$this->correct_notice = $correct_notice;
	}

	/**
	 * Get the notice of the incorrect answer.
	 *
	 * @return string
	 */
	public function get_incorrect_notice() {
		return $this->incorrect_notice;
	}

	/**
	 * Set the notice of the incorrect answer.
	 *
	 * @param string $incorrect_notice Notice of the incorrect answer.
	 */
	public function set_incorrect_notice( $incorrect_notice ) {
		$this->incorrect_notice = $incorrect_notice;
	}

	/**
	 * Get the distractor item.
	 *
	 * @return string
	 */
	public function get_distractor() {
		return $this->distractor;
	}

	/**
	 * Set the distractor item.
	 *
	 * @param string $distractor The distractor item.
	 */
	public function set_distractor( $distractor ) {
		$this->distractor = $distractor;
	}
}
