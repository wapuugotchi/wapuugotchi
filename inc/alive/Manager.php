<?php
/**
 * The Manager Class.
 *
 * This class is responsible for managing the animations in the WapuuGotchi plugin.
 * It provides methods to extract animations from an avatar and add them to the admin dashboard.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Alive;

use Wapuugotchi\Alive\Handler\AnimationHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 *
 * This class is responsible for managing the animations in the WapuuGotchi plugin.
 * It provides methods to extract animations from an avatar and add them to the admin dashboard.
 *
 * @package WapuuGotchi
 */
class Manager {
	const ANIMATION_HANDLE = 'wapuugotchi-alive';

	/**
	 * "Constructor" of this Class
	 *
	 * This method initializes the Manager class by adding the necessary filters and actions.
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_avatar', array( AnimationHandler::class, 'extract_animations' ), PHP_INT_MAX, 1 );
		\add_action( 'animations_extracted', array( $this, 'add_animations' ) );
	}

	/**
	 * Adds animations to the admin dashboard.
	 *
	 * This method is hooked into the 'animations_extracted' action and adds the extracted animations
	 * to the admin dashboard by enqueuing a script and passing the animations to it.
	 *
	 * @param array $animations The animations to add.
	 * @return void
	 */
	public function add_animations( $animations ) {
		global $current_screen;
		if ( ! $current_screen || 'dashboard' !== $current_screen->id ) {
			return;
		}

		\add_action(
			'admin_enqueue_scripts',
			function () use ( $animations ) {
				$assets = include_once WAPUUGOTCHI_PATH . 'build/alive.asset.php';
				if ( \is_array( $assets ) ) {
					\wp_enqueue_script( self::ANIMATION_HANDLE, WAPUUGOTCHI_URL . 'build/alive.js', $assets['dependencies'], $assets['version'], true );
					\wp_add_inline_script( self::ANIMATION_HANDLE, 'var wapuugotchiAnimations = ' . wp_json_encode( $animations ) . ';', 'before' );
				}
			},
			20
		);
	}
}
