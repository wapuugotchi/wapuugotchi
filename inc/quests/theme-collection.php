<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Theme_Collection {

	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
		//add_filter('admin_init', array($this, 'add_wapuugotchi_filter'));

	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'cleanup_themes_1', null, 'Remove all unused themes', 'You cleaned up! &#129529;' . PHP_EOL . 'We have only one theme now.', 100, 15, 'Wapuugotchi\Wapuugotchi\Theme_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Theme_Collection::cleanup_themes_completed_1' ),
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
