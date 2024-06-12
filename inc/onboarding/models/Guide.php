<?php
/**
 * The Guide Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Element
 */
class Guide {

	/**
	 * The name of the page.
	 *
	 * @var string
	 */
	public $page = '';

	/**
	 * The file name of the page.
	 *
	 * @var string
	 */
	public $file = '';

	/**
	 * The list of items for the page.
	 * The list is an array of OnboardingItem objects.
	 *
	 * @var array
	 */
	public $item_list = array();

	/**
	 * Instantiates and returns an object of this class
	 *
	 * @return Guide
	 */
	public static function create() {
		return new Guide();
	}

	/**
	 * Sets the page name
	 *
	 * @param string $page The name of the page.
	 *
	 * @return Guide the current instance of the class.
	 */
	public function set_page( $page ) {
		$this->page = $page;

		return $this;
	}

	/**
	 * Sets the file name of the page.
	 *
	 * @param string $file The file name of the page.
	 *
	 * @return Guide the current instance of the class.
	 */
	public function set_file( $file ) {
		$this->file = $file;

		return $this;
	}

	/**
	 * Adds an item to the list of items for the page.
	 *
	 * @param Item $item The list of items for the page.
	 *
	 * @return Guide the current instance of the class.
	 */
	public function add_item( $item ) {
		$this->item_list[] = $item;

		return $this;
	}
}
