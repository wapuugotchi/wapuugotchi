<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class NotificationUpdate {

	public function __construct() {
		add_filter( 'wapuugotchi_notification_filter', array( $this, 'wapuugotchi_notifications' ) );
	}

	public function wapuugotchi_notifications( $quests ) {

		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Notification('wp_update_4.3', 'Es gibt ein Update auf WordPress 4.3! &#10024;', 'warning', strtotime("tomorrow") ),
			new \Wapuugotchi\Wapuugotchi\Notification('wp_update_4.1', 'Es gibt ein Update auf WordPress 4.1! &#10024;', 'warning', strtotime("+2 days") ),
		);

		return array_merge( $default_quest, $quests );
	}
}
