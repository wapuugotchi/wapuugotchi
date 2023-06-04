<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class NotificationManager {

	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ), 20, 0 );
	}

	public function init() {
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi_confirmed_notifications__alpha', true ) ) ) {
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_confirmed_notifications__alpha',
				array()
			);
		}
		$this->cleanup_notifications();
	}
	public static function get_all_notifications() {
		$notifications = wp_cache_get( 'wapuugotchi_notifications' );

		if ( ! empty( $notifications ) ) {
			return $notifications;
		}
		$notifications = apply_filters( 'wapuugotchi_notification_filter', array() );

		wp_cache_set( 'wapuugotchi_notifications', $notifications );

		return $notifications;
	}

	public static function get_active_quests() {
		$notifications = self::get_all_notifications();
		$confirmed_notifications = get_user_meta(
			get_current_user_id(),
			'wapuugotchi_confirmed_notifications__alpha',
			true
		);
		$result = array();

		foreach ( $notifications as $index => $notification ) {
			if(in_array( $notification->getId(), array_keys( $confirmed_notifications) ) ) {
				continue;
			}

			$result[] = array(
				'id' => $notification->getId(),
				'category' => 'notification',
				'message' => $notification->getMessage(),
				'type' => $notification->getType(),
				'remember' => $notification->getRemember()
			);
		}

		return $result;

	}

	private static function cleanup_notifications() {
		$confirmed_notifications = get_user_meta(
			get_current_user_id(),
			'wapuugotchi_confirmed_notifications__alpha',
			true
		);

		if (empty( $confirmed_notifications) ) {
			return $confirmed_notifications;
		}
		foreach( $confirmed_notifications as $key => $notification ) {
			if( $notification['remember'] >= strtotime("now") ) {
				continue;
			}
			unset( $confirmed_notifications[ $key ] );
		}

		update_user_meta(
			get_current_user_id(),
			'wapuugotchi_confirmed_notifications__alpha',
			$confirmed_notifications
		);
	}
}
