<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class QuestStart {


	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'first_start_1', null, __( 'Welcome to Wapuugotchi', 'wapuugotchi' ), __( 'Thank you for giving me a home! &#10084;&#65039;', 'wapuugotchi' ), 'success', 100, 150, 'Wapuugotchi\Wapuugotchi\QuestStart::always_true', 'Wapuugotchi\Wapuugotchi\QuestStart::always_true' ),
		);

		return array_merge( $default_quest, $quests );
	}

	public static function always_true() {
		return true;
	}
}
