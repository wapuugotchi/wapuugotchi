<?php
/**
 * The PwnedHandler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security\Handler;

use Wapuugotchi\Security\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Checks the user's password against the HaveIBeenPwned k-Anonymity API at login.
 *
 * Only the first 5 characters of the SHA-1 hash are transmitted — the full
 * password and the full hash never leave the server.
 */
class PwnedHandler {

	/**
	 * WapuuGotchi Security relay endpoint for HIBP range lookups.
	 */
	const HIBP_API_URL = 'https://security.wapuugotchi.com/api/check.php';

	/**
	 * Run the HIBP check after a successful login.
	 *
	 * Hooked into the 'authenticate' filter at PHP_INT_MAX so that $user is
	 * already resolved to a WP_User on success. Runs at most once per day.
	 *
	 * @param \WP_User|\WP_Error|null $user     Resolved authentication result.
	 * @param string                  $username Username (unused).
	 * @param string                  $password Plaintext password from the login form.
	 *
	 * @return \WP_User|\WP_Error|null Unchanged — this handler never modifies the result.
	 */
	public static function maybe_check_at_login( $user, $username, $password ) {
		if ( ! ( $user instanceof \WP_User ) || empty( $password ) ) {
			return $user;
		}

		$user_id = $user->ID;
		$hash    = \strtoupper( \sha1( $password ) );
		$prefix  = \substr( $hash, 0, 5 );
		$suffix  = \substr( $hash, 5 );

		$response = \wp_remote_get(
			\add_query_arg( 'prefix', $prefix, self::HIBP_API_URL ),
			array(
				'timeout'    => 5,
				'user-agent' => 'WapuuGotchi WordPress Plugin (https://wapuugotchi.com)',
			)
		);

		if ( \is_wp_error( $response ) || 200 !== \wp_remote_retrieve_response_code( $response ) ) {
			return $user;
		}

		$pwned = \stripos( \wp_remote_retrieve_body( $response ), $suffix . ':' ) !== false;

		\update_user_meta( $user_id, Meta::PWNED_RESULT_META_KEY, $pwned );

		if ( $pwned ) {
			$today = \wp_date( 'Y-m-d' );
			$meta  = \get_user_meta( $user_id, Meta::DISMISSED_META_KEY, true );
			if ( \is_array( $meta ) && ( $meta['date'] ?? '' ) === $today ) {
				$meta['ids'] = \array_values( \array_diff( $meta['ids'] ?? array(), array( 'security-pwned' ) ) );
				\update_user_meta( $user_id, Meta::DISMISSED_META_KEY, $meta );
			}
		}

		return $user;
	}
}
