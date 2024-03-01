<?php
/**
 * The OnboardingItem Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Models;

use Wapuugotchi\Wapuugotchi\OnboardingTarget;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Quest
 */
class OnboardingItem {

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
	 * The list of targets for the page item.
	 * The list is an array of OnboardingTarget objects.
	 *
	 * @var array
	 */
	public $target_list = array();

	/**
	 * "Constructor" of the class
	 */
	public static function create() {
		return new OnboardingItem();
	}

	/**
	 * @param string $title
	 *
	 * @return OnboardingItem
	 */
	public function set_title( $title ) {
		$this->title = $title;
		return $this;
	}

	/**
	 * @param string $texta
	 *
	 * @return OnboardingItem
	 */
	public function set_text( $text ) {
		$this->text = $text;
		return $this;
	}


	/**
	 * @param string $freeze
	 *
	 * @return OnboardingItem
	 */
	public function set_freeze( $freeze ) {
		$this->freeze = $freeze;
		return $this;
	}

	/**
	 * Adds a target to the onboarding item.
	 *
	 * @param OnboardingTarget $target The target that shall be added.
	 *
	 * @return OnboardingItem
	 */
	public function add_target( $target ) {
		$this->target_list[] = $target;
		return $this;
	}
}
