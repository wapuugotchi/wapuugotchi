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
		\add_filter( 'wapuugotchi_bubble_messages', array( Greeting::class, 'add_greetings_filter' ), 10, 1 );

		$settings = \get_option( 'wapuugotchi_settings', array() );
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
			'key'         => 'feed',
			'label'       => \__( 'News Feed', 'wapuugotchi' ),
			'description' => \__( "Your Wapuu keeps you up to date with everything happening in the WordPress universe — from upcoming releases to community highlights.\nIt fetches this content via our feed service (feed.wapuugotchi.com). What you read stays between you and your Wapuu.", 'wapuugotchi' ),
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
