<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security;

use Wapuugotchi\Security\Data\AutoMessage;
use Wapuugotchi\Security\Data\PwnedMessage;
use Wapuugotchi\Security\Handler\CheckHandler;
use Wapuugotchi\Security\Handler\PwnedHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Bootstraps the security feature.
 */
class Manager {
	/**
	 * Constructor.
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_register_settings', array( $this, 'register_setting' ) );

		$settings = \get_option( 'wapuugotchi_settings', array() );
		if ( ( $settings['security'] ?? false ) === false ) {
			return;
		}

		\add_action( 'load-index.php', array( CheckHandler::class, 'maybe_run_daily_security_check' ) );
		\add_filter( 'wapuugotchi_bubble_messages', array( AutoMessage::class, 'add_security_messages_filter' ), 100, 1 );

		if ( ( $settings['hibp'] ?? false ) !== false ) {
			\add_filter( 'authenticate', array( PwnedHandler::class, 'maybe_check_at_login' ), PHP_INT_MAX, 3 );
			\add_filter( 'wapuugotchi_bubble_messages', array( PwnedMessage::class, 'add_pwned_message_filter' ), 110, 1 );
		}
	}

	/**
	 * Register this feature in the settings page.
	 *
	 * @param array $features Registered features.
	 *
	 * @return array
	 */
	public function register_setting( $features ) {
		$features[] = array(
			'key'         => 'security',
			'label'       => \__( 'Plugin Vulnerabilities', 'wapuugotchi' ),
			'description' => \__( "Your Wapuu performs daily security checks on your installed plugins and warns you if any known vulnerabilities are found.\nWe handle this through our service (security.wapuugotchi.com) — we don't track, log, or store anything about your site. Your site, your data — we only check, never collect.", 'wapuugotchi' ),
			'default'     => true,
		);

		$features[] = array(
			'key'         => 'hibp',
			'label'       => \__( 'Password Breach Check', 'wapuugotchi' ),
			'description' => \__( "Your Wapuu checks whether your password has appeared in a known data breach and warns you on every login if so.\nWe handle this through our service (security.wapuugotchi.com) — designed so your password never leaves your system. Your data is yours.", 'wapuugotchi' ),
			'default'     => false,
		);

		return $features;
	}
}
