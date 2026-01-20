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
		\delete_transient( 'wapuugotchi_buddy__greeting' );
		\add_filter( 'wapuugotchi_bubble_messages', array( Greeting::class, 'add_greetings_filter' ), PHP_INT_MAX, 1 );
		\add_action( 'admin_enqueue_scripts', array( $this, 'add_feed_script' ), PHP_INT_MAX );
		\add_filter( 'wapuugotchi_bubble_messages', array( Feed::class, 'add_feed_filter' ), PHP_INT_MAX, 1 );
	}

	public function add_feed_script() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/feed.asset.php';
		\wp_enqueue_script( "wapuugotchi-feed", WAPUUGOTCHI_URL . 'build/feed.js', $assets['dependencies'], $assets['version'], true );
		\wp_enqueue_style( 'wapuugotchi-feed', WAPUUGOTCHI_URL . 'build/feed.css', array(), $assets['version'] );
	}
}
