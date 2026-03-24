<?php
/**
 * The Check Handler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security\Handler;

use Wapuugotchi\Security\Api;
use Wapuugotchi\Security\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Runs and persists the daily security check.
 */
class CheckHandler {
	/**
	 * Run the daily check once per user and day when landing on the dashboard.
	 *
	 * @return void
	 */
	public static function maybe_run_daily_security_check() {
		if ( ! \is_user_logged_in() || ! \current_user_can( 'update_plugins' ) ) {
			return;
		}

		$user_id = \get_current_user_id();
		if ( ! $user_id ) {
			return;
		}

		$today        = \wp_date( 'Y-m-d' );
		$last_checked = \get_user_meta( $user_id, Meta::LAST_CHECKED_META_KEY, true );

		if ( $today === $last_checked ) {
			return;
		}

		$plugins = PluginHandler::get_plugins_payload();
		$result  = Api::fetch_security_data( $plugins );

		\update_user_meta( $user_id, Meta::RESULT_META_KEY, $result );
		\update_user_meta( $user_id, Meta::LAST_CHECKED_META_KEY, $today );
		\update_user_meta(
			$user_id,
			Meta::DISMISSED_META_KEY,
			array(
				'date' => $today,
				'ids'  => array(),
			)
		);
	}
}
