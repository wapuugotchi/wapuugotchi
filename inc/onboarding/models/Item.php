<?php
/**
 * The Item Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Quest
 */
class Item {

	/**
	 * The title of the page item.
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * The text of the page item.
	 *
	 * @var string|null
	 */
	public $text = '';

	/**
	 * Freeze the page if the item is active.
	 *
	 * @var string|null
	 */
	public $freeze = '';

	/**
	 * The list is an array of Target objects.
	 *
	 * @var array
	 */
	public $target_list = array();

	/**
	 * "Constructor" of the class
	 */
	public static function create() {
		return new Item();
	}

	/**
	 * Sets the title of the onboarding item.
	 *
	 * @param string $title The title of the onboarding item.
	 *
	 * @return Item The current instance of the class.
	 */
	public function set_title( $title ) {
		$this->title = $title;

		return $this;
	}

	/**
	 * Sets the text of the onboarding item.
	 *
	 * @param string $text The text of the onboarding item.
	 *
	 * @return Item The current instance of the class.
	 */
	public function set_text( $text ) {
		$this->text = $text;

		return $this;
	}


	/**
	 * Sets the freeze of the onboarding item.
	 *
	 * @param string $freeze The freeze of the onboarding item.
	 *
	 * @return Item The current instance of the class.
	 */
	public function set_freeze( $freeze ) {
		$this->freeze = $freeze;

		return $this;
	}

	/**
	 * Adds a target to the onboarding item.
	 *
	 * @param Target $target The target that shall be added.
	 *
	 * @return Item The current instance of the class.
	 */
	public function add_target( $target ) {
		$this->target_list[] = $target;

		return $this;
	}
}
