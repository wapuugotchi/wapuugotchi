<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Buddy;

use Wapuugotchi\Buddy\Data\Greeting;
use Wapuugotchi\Buddy\Data\Feed;

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
		\add_filter( 'wapuugotchi_bubble_messages', array( Greeting::class, 'add_greetings_filter' ), PHP_INT_MAX, 1 );
		\add_filter( 'wapuugotchi_bubble_messages', array( Feed::class, 'add_feed_filter' ), PHP_INT_MAX, 1 );
	}
}
