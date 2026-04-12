<?php
/**
 * The Meta Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Shared user meta keys for the security feature.
 */
class Meta {
	/**
	 * User meta key storing the last dashboard check date.
	 */
	const LAST_CHECKED_META_KEY = 'wapuugotchi_security_last_checked_on';

	/**
	 * User meta key storing the last fetched security result.
	 */
	const RESULT_META_KEY = 'wapuugotchi_security_result';

	/**
	 * User meta key storing dismissed security message ids for the current day.
	 */
	const DISMISSED_META_KEY = 'wapuugotchi_security_dismissed_messages';

	/**
	 * User meta key storing the result of the last HaveIBeenPwned check.
	 */
	const PWNED_RESULT_META_KEY = 'wapuugotchi_security_pwned_result';
}
