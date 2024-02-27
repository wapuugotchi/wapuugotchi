<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

use Wapuugotchi\Models\stringnull;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Quest
 */
class OnboardingTarget {

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
	 * Hoverability of the Element.
	 *
	 * @var string
	 */
	public $hover = 0;

	/**
	 * @param bool|string $active
	 */
	public function set_active( $active ) {
		$this->active = $active;
		return $this;
	}

	/**
	 * @param string|null $focus
	 */
	public function set_focus( $focus ) {
		$this->focus = $focus;
		return $this;
	}

	/**
	 * @param string|null $overlay
	 *
	 * @return OnboardingTarget
	 */
	public function set_overlay( $overlay ) {
		$this->overlay = $overlay;
		return $this;
	}

	/**
	 * @param int|string $delay
	 *
	 * @return OnboardingTarget
	 */
	public function set_delay( $delay ) {
		$this->delay = $delay;
		return $this;
	}

	/**
	 * @param string $color
	 *
	 * @return OnboardingTarget
	 */
	public function set_color( $color ) {
		$this->color = $color;
		return $this;
	}

	/**
	 * @param string|null $click
	 *
	 * @return OnboardingTarget
	 */
	public function set_click( $click ) {
		$this->click = $click;
		return $this;
	}

	/**
	 * @param int|string $clickable
	 *
	 * @return OnboardingTarget
	 */
	public function set_clickable( $clickable ) {
		$this->clickable = $clickable;
		return $this;
	}

	/**
	 * @param false|int|string $hover
	 *
	 * @return OnboardingTarget
	 */
	public function set_hover( $hover ) {
		$this->hover = $hover;
		return $this;
	}

	/**
	 * @return OnboardingTarget
	 */
	public static function create() {
		return new OnboardingTarget();
	}
}
