<?php
/**
 * The Hunt Model.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Hunt\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Hunt
 */
class Hunt {
	/**
	 * ID of the quiz.
	 *
	 * @var string
	 */
	private $id = '';

	/**
	 * Initial quiz text
	 *
	 * @var string
	 */
	private $quest_text = '';

	/**
	 * Notice if the task is successfull.
	 *
	 * @var string
	 */
	private $success_text = '';

	/**
	 * The page name where the quest item is located.
	 *
	 * @var string
	 */
	private $page_name = '';

	/**
	 * Concrete selector on the page where the quest item is located.
	 *
	 * @var array
	 */
	private $selectors = '';

	/**
	 * Indicates the state of the hunt.
	 *
	 * @var string
	 */
	private $state = 'none';

	/**
	 * "Constructor" of this Class
	 *
	 * @param string $id ID of the quiz.
	 * @param string $quest_text Initial quest text.
	 * @param string $success_text Notice if the task is successfull.
	 * @param string $page_name The page name where the quest item is located.
	 * @param array  $selectors Concrete selector on the page where the quest item is located.
	 */
	public function __construct( $id, $quest_text, $success_text, $page_name, $selectors ) {
		$this->id           = $id;
		$this->quest_text   = $quest_text;
		$this->success_text = $success_text;
		$this->page_name    = $page_name;
		$this->selectors    = $selectors;
	}

	/**
	 * Get the ID of the quiz.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Get the initial quest text.
	 *
	 * @return string
	 */
	public function get_quest_text() {
		return $this->quest_text;
	}

	/**
	 * Get the notice if the task is successfull.
	 *
	 * @return string
	 */
	public function get_success_text() {
		return $this->success_text;
	}

	/**
	 * Get the page name where the quest item is located.
	 *
	 * @return string
	 */
	public function get_page_name() {
		return $this->page_name;
	}

	/**
	 * Get the concrete selector on the page where the quest item is located.
	 *
	 * @return array
	 */
	public function get_selectors() {
		return $this->selectors;
	}

	/**
	 * Get the state of the hunt.
	 *
	 * @return string
	 */
	public function get_state() {
		return $this->state;
	}

	/**
	 * Set the state of the hunt.
	 *
	 * @param string $state The state of the hunt.
	 */
	public function set_state( $state ) {
		$this->state = $state;
	}

	/**
	 * Set the ID of the quiz.
	 *
	 * @param string $id ID of the quiz.
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Set the initial quest text.
	 *
	 * @param string $quest_text Initial quest text.
	 */
	public function set_quest_text( $quest_text ) {
		$this->quest_text = $quest_text;
	}

	/**
	 * Set the notice if the task is successfull.
	 *
	 * @param string $success_text Notice if the task is successfull.
	 */
	public function set_success_text( $success_text ) {
		$this->success_text = $success_text;
	}

	/**
	 * Set the page name where the quest item is located.
	 *
	 * @param string $page_name The page name where the quest item is located.
	 */
	public function set_page_name( $page_name ) {
		$this->page_name = $page_name;
	}

	/**
	 * Set the concrete selector on the page where the quest item is located.
	 *
	 * @param array $selectors Concrete selector on the page where the quest item is located.
	 */
	public function set_selectors( $selectors ) {
		$this->selectors = $selectors;
	}
}
