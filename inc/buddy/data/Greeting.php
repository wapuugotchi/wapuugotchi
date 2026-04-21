<?php
/**
 * The Greeting Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Buddy\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Greeting
 */
class Greeting {

	/**
	 * The user meta key for the last visit timestamp.
	 */
	const LAST_VISIT_KEY = 'wapuugotchi_last_visit';

	/**
	 * Pearl bonus awarded when returning after 1+ month of absence.
	 */
	const LONG_ABSENCE_PEARL_BONUS = 5;

	/**
	 * Cached days since last visit (avoids repeated meta reads per request).
	 *
	 * @var int|null
	 */
	private static $days_absent = null;

	/**
	 * Return the number of full calendar days since the current user's last visit.
	 * Returns 1 for first-time visitors (no stored last visit).
	 * Returns 0 if the last visit was today.
	 *
	 * @return int
	 */
	private static function get_days_absent() {
		if ( null !== self::$days_absent ) {
			return self::$days_absent;
		}

		$last_visit = \get_user_meta( \get_current_user_id(), self::LAST_VISIT_KEY, true );

		if ( ! $last_visit ) {
			self::$days_absent = 1;
			return self::$days_absent;
		}

		$timezone        = new \DateTimeZone( \wp_timezone_string() );
		$last_visit_date = new \DateTime( '@' . $last_visit );
		$last_visit_date->setTimezone( $timezone );
		$last_visit_date->setTime( 0, 0, 0 );
		$today = new \DateTime( 'now', $timezone );
		$today->setTime( 0, 0, 0 );

		self::$days_absent = (int) $today->diff( $last_visit_date )->days;
		return self::$days_absent;
	}

	/**
	 * Determine whether the greeting should be shown to the current user.
	 * Updates the last-visit timestamp and awards a Pearl bonus for long absences.
	 *
	 * @return bool
	 */
	public static function is_active() {
		if ( self::get_days_absent() === 0 ) {
			return false;
		}

		if ( self::get_days_absent() >= 28 ) {
			\do_action( 'wapuugotchi_add_pearls', self::LONG_ABSENCE_PEARL_BONUS );
		}

		\update_user_meta( \get_current_user_id(), self::LAST_VISIT_KEY, \time() );
		self::$days_absent = 0;

		return true;
	}

	/**
	 * Mark the greeting as handled.
	 * The last-visit timestamp is already updated in is_active(), so nothing to do here.
	 *
	 * @return bool
	 */
	public static function handle_submit() {
		return true;
	}

	/**
	 * Add a greeting to the beginning of the bubble messages.
	 *
	 * @param array $messages The messages.
	 *
	 * @return array
	 **/
	public static function add_greetings_filter( $messages ) {
		$greeting = self::get_contextual_greeting();

		if ( ! self::is_active() ) {
			return $messages;
		}

		if ( empty( $messages ) ) {
			\array_unshift(
				$messages,
				new \Wapuugotchi\Avatar\Models\Message(
					'buddy-greeting',
					$greeting . ' ' . self::get_random_quiet_text(),
					'none',
					'__return_true',
					'Wapuugotchi\Buddy\Data\Greeting::handle_submit'
				)
			);

			return $messages;
		}

		$first       = $messages[0];
		$messages[0] = new \Wapuugotchi\Avatar\Models\Message(
			$first->get_id(),
			$greeting . '<br>' . $first->get_message(),
			$first->get_type(),
			$first->get_is_active_callback(),
			$first->get_handle_submit_callback()
		);

		return $messages;
	}

	/**
	 * Return a random "nothing special today" text.
	 *
	 * @return string
	 */
	private static function get_random_quiet_text(): string {
		$texts = array(
			\__( 'No special events today — just enjoy your day!', 'wapuugotchi' ),
			\__( 'All quiet today — nothing to report.', 'wapuugotchi' ),
			\__( 'No news is good news — have a great day!', 'wapuugotchi' ),
		);

		return $texts[ \array_rand( $texts ) ];
	}

	/**
	 * Return a greeting tailored to how long the user has been away.
	 *
	 * @return string
	 */
	public static function get_contextual_greeting() {
		$days = self::get_days_absent();
		$name = \wp_get_current_user()->display_name ?: \__( 'Dude', 'wapuugotchi' );

		if ( $days >= 28 ) {
			$greetings = array(
				/* translators: %s: user's display name */
				\__( 'Wow, it\'s been forever! I\'m so happy to see you, %s! 🥰', 'wapuugotchi' ),
				/* translators: %s: user's display name */
				\__( 'I thought you forgot about me, %s! 🥲', 'wapuugotchi' ),
				/* translators: %s: user's display name */
				\__( 'Oh my, %s — it\'s been so long! Welcome back! 😍', 'wapuugotchi' ),
			);
			return \sprintf( $greetings[ \array_rand( $greetings ) ], $name );
		}

		if ( $days >= 8 ) {
			$greetings = array(
				/* translators: %s: user's display name */
				\__( 'I missed you! Welcome back, %s. 🥰', 'wapuugotchi' ),
				/* translators: %s: user's display name */
				\__( 'Long time no see, %s — great to have you back! 😍', 'wapuugotchi' ),
				/* translators: %s: user's display name */
				\__( 'Hey %s, it\'s been a while. Everything okay? 😟', 'wapuugotchi' ),
			);
			return \sprintf( $greetings[ \array_rand( $greetings ) ], $name );
		}

		if ( $days >= 3 ) {
			$greetings = array(
				/* translators: %s: user's display name */
				\__( 'Hey %s, great to have you back! 🤗', 'wapuugotchi' ),
				/* translators: %s: user's display name */
				\__( 'It\'s not the same without you, %s. 😍', 'wapuugotchi' ),
				/* translators: %s: user's display name */
				\__( 'Good to see you again, %s! 🥰', 'wapuugotchi' ),
				/* translators: %s: user's display name */
				\__( 'Hey %s, I was wondering where you went! ❤️', 'wapuugotchi' ),
			);
			return \sprintf( $greetings[ \array_rand( $greetings ) ], $name );
		}

		return self::get_random_greeting();
	}

	/**
	 * Get a random everyday greeting (used for absences of 1–2 days).
	 *
	 * @return string
	 */
	public static function get_random_greeting() {
		$greetings = array(
			/* translators: %s: user's display name */
			\__( 'Hi %s, great to see you! 🤗', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, how are you today? 💪' , 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, did you sleep well? ✨', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hi %s, how has your day been so far? ✨', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, ready for a new day? 💪', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hello %s, what do you have planned today? ✨', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hi %s, fancy a coffee? ☕', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, it\'s always a pleasure to see you! 🥰', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, you look great today. ❤️', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hi %s, good to have you here. 🤗', 'wapuugotchi' ),		);

		return \sprintf(
			$greetings[ \array_rand( $greetings ) ],
			\wp_get_current_user()->display_name ?: \__( 'Dude', 'wapuugotchi' )
		);
	}
}
