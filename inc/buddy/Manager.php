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
		\add_filter( 'wapuugotchi_register_settings', array( $this, 'register_settings' ) );

		$settings = \get_option( 'wapuugotchi_settings', array() );

		if ( ( $settings['buddy'] ?? true ) !== false ) {
			\add_filter( 'wapuugotchi_bubble_messages', array( Greeting::class, 'add_greetings_filter' ), 10, 1 );
		}

		if ( ( $settings['feed'] ?? true ) !== false ) {
			\add_action( 'admin_enqueue_scripts', array( $this, 'add_feed_script' ), PHP_INT_MAX );
			\add_filter( 'wapuugotchi_bubble_messages', array( Feed::class, 'add_feed_filter' ), PHP_INT_MAX, 1 );
		}
	}

	/**
	 * Register buddy and feed features in the settings page.
	 *
	 * @param array $features Registered features.
	 *
	 * @return array
	 */
	public function register_settings( $features ) {
		$features[] = array(
			'key'         => 'buddy',
			'label'       => \__( 'Buddy Greetings', 'wapuugotchi' ),
			'description' => \__( 'Wapuu greets you once a day with a friendly message in the speech bubble.', 'wapuugotchi' ),
			'default'     => true,
		);

		$features[] = array(
			'key'         => 'feed',
			'label'       => \__( 'News Feed', 'wapuugotchi' ),
			'description' => \__( 'Wapuu fetches the latest WapuuGotchi news and shows them in the speech bubble.', 'wapuugotchi' ),
			'default'     => true,
		);

		return $features;
	}

	/**
	 * Enqueue feed assets for the admin bubble UI.
	 *
	 * @return void
	 */
	public function add_feed_script() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/feed.asset.php';
		\wp_enqueue_script( 'wapuugotchi-feed', WAPUUGOTCHI_URL . 'build/feed.js', $assets['dependencies'], $assets['version'], true );
		\wp_enqueue_style( 'wapuugotchi-feed', WAPUUGOTCHI_URL . 'build/feed.css', array(), $assets['version'] );
	}
}
