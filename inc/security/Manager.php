<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security;

use Wapuugotchi\Security\Data\AutoMessage;
use Wapuugotchi\Security\Handler\CheckHandler;

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
		if ( ( $settings['security'] ?? true ) === false ) {
			return;
		}

		\add_action( 'load-index.php', array( CheckHandler::class, 'maybe_run_daily_security_check' ) );
		\add_filter( 'wapuugotchi_bubble_messages', array( AutoMessage::class, 'add_security_messages_filter' ), 100, 1 );
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
			'label'       => \__( 'Security Messages', 'wapuugotchi' ),
			'description' => \__( "Your Wapuu performs daily security checks and notifies you if any issues are found. It also shares helpful security tips.\nTo run vulnerability checks, it securely connects to our service (vulnerability.wapuugotchi.com).\nYour data stays yours — we don't access or store your personal content.", 'wapuugotchi' ),
			'default'     => false,
		);

		return $features;
	}
}
