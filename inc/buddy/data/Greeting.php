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
	 * Get true.
	 *
	 * @return bool
	 */
	public static function is_active() {
		if ( \get_transient( 'wapuugotchi_buddy__greeting' ) ) {
			return false;
		} else {
			\set_transient( 'wapuugotchi_buddy__greeting', true, self::get_seconds_until_tomorrow_morning() );
			return true;
		}
	}

	/**
	 * Set the transient.
	 *
	 * @return bool
	 */
	public static function handle_submit() {
		return \set_transient( 'wapuugotchi_buddy__greeting', true, self::get_seconds_until_tomorrow_morning() );
	}

	/**
	 * Add a greeting to the beginning of the bubble messages.
	 *
	 * @param array $messages The messages.
	 *
	 * @return array
	 * @throws \Exception When the timezone is invalid.
	 **/
	public static function add_greetings_filter( $messages ) {
		array_unshift(
			$messages,
			new \Wapuugotchi\Avatar\Models\Message(
				'buddy-greeting',
				self::get_random_greeting(),
				'none',
				'Wapuugotchi\Buddy\Data\Greeting::is_active',
				'Wapuugotchi\Buddy\Data\Greeting::handle_submit'
			)
		);

		return $messages;
	}

	/**
	 * Get the seconds remaining until tomorrow 00:00.
	 *
	 * @return int The number of seconds until midnight.
	 * @throws \Exception When the timezone is invalid.
	 */
	private static function get_seconds_until_tomorrow_morning() {
		$timezone = new \DateTimeZone( \wp_timezone_string() );

		$current_date_time  = new \DateTime( 'now', $timezone );
		$midnight_date_time = new \DateTime( 'tomorrow 06:00', $timezone );

		return $midnight_date_time->getTimestamp() - $current_date_time->getTimestamp();
	}

	/**
	 * Get random greeting text.
	 *
	 * @return string The greeting text.
	 */
	public static function get_random_greeting() {
		$greetings = array(
			/* translators: %s: user's display name */
			\__( 'Hi %s, great to see you!', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, how are you today?', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, did you sleep well?', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hi %s, how has your day been so far?', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, ready for a new day?', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, how are you today?', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hello %s, what do you have planned today?', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hi %s, fancy a coffee?', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, it\'s always a pleasure to see you!', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hey %s, you look great today.', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'Hi %s, good to have you here.', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( '%s, we are a great team!', 'wapuugotchi' ),
			/* translators: %s: user's display name */
			\__( 'It\'s not the same without you, %s.', 'wapuugotchi' ),
		);

		return \sprintf(
			$greetings[ \array_rand( $greetings ) ],
			\wp_get_current_user( 'display_name' )->display_name ?? \__( 'Dude', 'wapuugotchi' )
		);
	}
}
