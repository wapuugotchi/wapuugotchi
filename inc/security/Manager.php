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
		\add_action( 'load-index.php', array( CheckHandler::class, 'maybe_run_daily_security_check' ) );
		\add_filter( 'wapuugotchi_bubble_messages', array( AutoMessage::class, 'add_security_messages_filter' ) );
	}
}
