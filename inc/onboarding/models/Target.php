<?php
/**
 * The Onboarding Class.
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
class Target {

	/**
	 * ID of the Element.
	 *
	 * @var string
	 */
	public $active = true;

	/**
	 * Focus of the Element.
	 *
	 * @var string|null
	 */
	public $focus = null;

	/**
	 * Overlay of the Element.
	 *
	 * @var string|null
	 */
	public $overlay = null;

	/**
	 * Delay of the Element.
	 *
	 * @var string
	 */
	public $delay = 0;

	/**
	 * Color of the Element.
	 *
	 * @var string
	 */
	public $color = '#ffcc00';

	/**
	 * Click of the Element.
	 *
	 * @var string
	 */
	public $click = null;

	/**
	 * Clickable of the Element.
	 *
	 * @var string
	 */
	public $clickable = 0;

	/**
	 * Possible to hover the element
	 *
	 * @var string
	 */
	public $hover = 0;

	/**
	 * Create a new Target object
	 *
	 * @return Target New Target object.
	 */
	public static function create() {
		return new Target();
	}

	/**
	 * Set to active and return the Target object
	 *
	 * @param bool|string $active Active or not.
	 */
	public function set_active( $active ) {
		$this->active = $active;

		return $this;
	}

	/**
	 * Set the focus and return the Target object
	 *
	 * @param string|null $focus Focus.
	 */
	public function set_focus( $focus ) {
		$this->focus = $focus;

		return $this;
	}

	/**
	 * Set the overlay and return the Target object
	 *
	 * @param string|null $overlay Overlay.
	 *
	 * @return Target
	 */
	public function set_overlay( $overlay ) {
		$this->overlay = $overlay;

		return $this;
	}

	/**
	 * Set the delay and return the Target object
	 *
	 * @param int|string $delay Delay.
	 *
	 * @return Target
	 */
	public function set_delay( $delay ) {
		$this->delay = $delay;

		return $this;
	}

	/**
	 * Set the color and return the Target object
	 *
	 * @param string $color Color.
	 *
	 * @return Target
	 */
	public function set_color( $color ) {
		$this->color = $color;

		return $this;
	}

	/**
	 * Set the click and return the Target object
	 *
	 * @param string|null $click Click.
	 *
	 * @return Target
	 */
	public function set_click( $click ) {
		$this->click = $click;

		return $this;
	}

	/**
	 * Set the clickable and return the Target object
	 *
	 * @param int|string $clickable Clickable.
	 *
	 * @return Target
	 */
	public function set_clickable( $clickable ) {
		$this->clickable = $clickable;

		return $this;
	}

	/**
	 * Set the hover and return the Target object
	 *
	 * @param false|int|string $hover Hover.
	 *
	 * @return Target
	 */
	public function set_hover( $hover ) {
		$this->hover = $hover;

		return $this;
	}
}
