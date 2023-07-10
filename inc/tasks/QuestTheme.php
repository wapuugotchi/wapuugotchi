<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class QuestTheme {

	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'cleanup_themes_1', null, __( 'Remove all unused themes', 'wapuugotchi' ), __( 'You cleaned up! &#129529;', 'wapuugotchi' ) . PHP_EOL . 'We have only one theme now.', 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestTheme::always_true', 'Wapuugotchi\Wapuugotchi\QuestTheme::cleanup_themes_completed_1' ),
		);

		return array_merge( $default_quest, $quests );
	}

	public static function always_true() {
		return true;
	}

	public static function cleanup_themes_completed_1() {
		return ( count( wp_get_themes() ) === 1 );
	}
}
