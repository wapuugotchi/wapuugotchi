<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Notification;

use Wapuugotchi\Notification\Handler\NotificationHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 24 );
		\add_action( 'admin_init', array( NotificationHandler::class, 'init' ), PHP_INT_MAX, 1 );
	}
}
