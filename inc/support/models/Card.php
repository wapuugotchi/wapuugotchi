<?php
/**
 * The Card Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Support\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Card
 *
 * Represents a support card on the support page.
 */
class Card {
	/**
	 * The title of the card.
	 *
	 * @var string
	 */
	public $title = '';

	/**
	 * The description of the card.
	 *
	 * @var string
	 */
	public $description = '';

	/**
	 * Optional meta text for the card.
	 *
	 * @var string
	 */
	public $meta = '';

	/**
	 * Optional list items for the card.
	 *
	 * @var array
	 */
	public $list = array();

	/**
	 * Optional button data for the card.
	 *
	 * @var array|null
	 */
	public $button = null;

	/**
	 * Optional small text for the card.
	 *
	 * @var string
	 */
	public $small = '';

	/**
	 * Whether the card is highlighted.
	 *
	 * @var bool
	 */
	public $highlight = false;

	/**
	 * Creates a new instance of the Card class.
	 *
	 * @return Card The new instance of the Card class.
	 */
	public static function create() {
		return new Card();
	}

	/**
	 * Sets the title of the card.
	 *
	 * @param string $title The title of the card.
	 * @return Card The instance of the Card class.
	 */
	public function set_title( $title ) {
		$this->title = $title;

		return $this;
	}

	/**
	 * Sets the description of the card.
	 *
	 * @param string $description The description of the card.
	 * @return Card The instance of the Card class.
	 */
	public function set_description( $description ) {
		$this->description = $description;

		return $this;
	}

	/**
	 * Sets the meta text of the card.
	 *
	 * @param string $meta The meta text of the card.
	 * @return Card The instance of the Card class.
	 */
	public function set_meta( $meta ) {
		$this->meta = $meta;

		return $this;
	}

	/**
	 * Sets the list items of the card.
	 *
	 * @param array $items The list items of the card.
	 * @return Card The instance of the Card class.
	 */
	public function set_list( $items ) {
		$this->list = $items;

		return $this;
	}

	/**
	 * Sets the button data of the card.
	 *
	 * @param array $button The button data of the card.
	 * @return Card The instance of the Card class.
	 */
	public function set_button( $button ) {
		$this->button = $button;

		return $this;
	}

	/**
	 * Sets the small text of the card.
	 *
	 * @param string $small The small text of the card.
	 * @return Card The instance of the Card class.
	 */
	public function set_small( $small ) {
		$this->small = $small;

		return $this;
	}

	/**
	 * Sets whether the card is highlighted.
	 *
	 * @param bool $highlight Whether the card is highlighted.
	 * @return Card The instance of the Card class.
	 */
	public function set_highlight( $highlight ) {
		$this->highlight = $highlight;

		return $this;
	}
}
