<?php
/**
 * The Avatar Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Manager
 */
class Manager {
	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 */
	public function load_scripts() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/index.asset.php';
		\wp_enqueue_style( 'wapuugotchi-avatar', WAPUUGOTCHI_URL . 'build/index.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-avatar', WAPUUGOTCHI_URL . 'build/index.js', $assets['dependencies'], $assets['version'], true );
		\wp_add_inline_script(
			'wapuugotchi-avatar',
			sprintf(
				"wp.data.dispatch('wapuugotchi/wapuugotchi').__initialize(%s)",
				\wp_json_encode(
					array(
						'avatar'   => AvatarHandler::get_avatar(),
						'messages' => BubbleHandler::get_active_messages()
					)
				)
			)
		);
	}
}
