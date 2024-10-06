<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar;

use Wapuugotchi\Avatar\Handler\AvatarHandler;
use Wapuugotchi\Avatar\Handler\BubbleHandler;

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

		\add_action( 'rest_api_init', array( Api::class, 'register_endpoints' ) );
		\add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts and styles.
	 *
	 * @param string $hook_suffix The internal page name.
	 *
	 * @return void
	 */
	public function enqueue_scripts( $hook_suffix ) {
		if ( 'index.php' !== $hook_suffix ) {
			return;
		}

		$assets = include_once WAPUUGOTCHI_PATH . 'build/avatar.asset.php';
		\wp_enqueue_style( 'wapuugotchi-avatar', WAPUUGOTCHI_URL . 'build/avatar.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-avatar', WAPUUGOTCHI_URL . 'build/avatar.js', $assets['dependencies'], $assets['version'], true );
		\wp_add_inline_script(
			'wapuugotchi-avatar',
			sprintf(
				"wp.data.dispatch('wapuugotchi/avatar').__initialize(%s)",
				\wp_json_encode(
					array(
						'avatar'   => AvatarHandler::get_avatar(),
						'messages' => BubbleHandler::get_active_messages(),
					)
				)
			)
		);
	}
}
