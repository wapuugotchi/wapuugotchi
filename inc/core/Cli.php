<?php
/**
 * WP-CLI commands for WapuuGotchi.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Cli
 */
class Cli {
	/**
	 * Prefix used for WapuuGotchi transients and user meta.
	 *
	 * @var string
	 */
	const DATA_PREFIX = 'wapuugotchi_';

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\WP_CLI::add_command( 'wapuugotchi', $this );
	}

	/**
	 * Reset WapuuGotchi data (transients + user meta).
	 *
	 * ## OPTIONS
	 *
	 * [--user=<id>]
	 * : Reset data for a single user ID only.
	 *
	 * ## EXAMPLES
	 *
	 *     wp wapuugotchi reset
	 *     wp wapuugotchi reset --user=123
	 *
	 * @param array $args Command args.
	 * @param array $assoc_args Command assoc args.
	 *
	 * @return void
	 */
	public function reset( $args, $assoc_args ) {
		$user_id = isset( $assoc_args['user'] ) ? (int) $assoc_args['user'] : 0;

		if ( $user_id > 0 && ! \get_user_by( 'id', $user_id ) ) {
			\WP_CLI::error( 'User not found.' );
		}

		global $wpdb;

		$meta_like = $wpdb->esc_like( self::DATA_PREFIX ) . '%';
		if ( $user_id > 0 ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$deleted_meta = $wpdb->query(
				$wpdb->prepare(
					"DELETE FROM {$wpdb->usermeta} WHERE user_id = %d AND meta_key LIKE %s",
					$user_id,
					$meta_like
				)
			);
		} else {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
			$deleted_meta = $wpdb->query(
				$wpdb->prepare(
					"DELETE FROM {$wpdb->usermeta} WHERE meta_key LIKE %s",
					$meta_like
				)
			);
		}

		$transient_like         = $wpdb->esc_like( '_transient_' . self::DATA_PREFIX ) . '%';
		$transient_timeout_like = $wpdb->esc_like( '_transient_timeout_' . self::DATA_PREFIX ) . '%';
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$deleted_transients = $wpdb->query(
			$wpdb->prepare(
				"DELETE FROM {$wpdb->options} WHERE option_name LIKE %s OR option_name LIKE %s",
				$transient_like,
				$transient_timeout_like
			)
		);

		\WP_CLI::success(
			sprintf(
				'Reset complete. Deleted %d user meta rows and %d transients.',
				(int) $deleted_meta,
				(int) $deleted_transients
			)
		);
	}
}
