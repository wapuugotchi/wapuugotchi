<?php
/**
 * The OnboardingPage Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Models;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Element
 */
class OnboardingPage {

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
	 * @return OnboardingPage
	 */
	public static function create() {
		return new OnboardingPage();
	}

	/**
	 * @param string $page
	 *
	 * @return OnboardingPage
	 */
	public function set_page( $page ) {
		$this->page = $page;
		return $this;
	}

	/**
	 * @param string $file
	 *
	 * @return OnboardingPage
	 */
	public function set_file( $file ) {
		$this->file = $file;
		return $this;
	}

	/**
	 * @param array $item_list
	 *
	 * @return OnboardingPage
	 */
	public function add_item( $item ) {
		$this->item_list[] = $item;
		return $this;
	}
}
