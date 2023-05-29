<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Start_Collection {

	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'first_start_1', null, 'Welcome to Wapuugotchi', 'Thank you for giving me a home! &#10084;&#65039;', 100, 5, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true' ),
		);

		return array_merge( $default_quest, $quests );
	}

	public static function always_true() {
		return true;
	}
}
