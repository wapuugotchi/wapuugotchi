<?php
/**
 * The Manager Class.
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
 */
class Manager {
	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_avatar', array( AnimationHandler::class, 'extract_animations' ), PHP_INT_MAX, 1 );
		\add_action( 'animations_extracted', array( $this, 'add_animations' ) );
	}

	/**
	 * Init plugin.
	 *
	 * @return void
	 */
	public function add_animations( $animations ) {
		global $current_screen;
		if ( ! $current_screen || 'dashboard' !== $current_screen->id ) {
			return;
		}

		\add_action( 'admin_enqueue_scripts', function () use ( $animations ) {
			$assets = include_once WAPUUGOTCHI_PATH . 'build/alive.asset.php';
			\wp_enqueue_style( 'wapuugotchi-alive', WAPUUGOTCHI_URL . 'build/alive.css', array(), $assets['version'] );
			\wp_enqueue_script( 'wapuugotchi-alive', WAPUUGOTCHI_URL . 'build/alive.js', $assets['dependencies'], $assets['version'], true );
			\wp_add_inline_script(
				'wapuugotchi-alive',
				sprintf(
					"wp.data.dispatch('wapuugotchi/alive').__initialize(%s)",
					\wp_json_encode(
						array(
							'animations' => $animations,
						)
					)
				)
			);

		}, 20 );

	}
}
