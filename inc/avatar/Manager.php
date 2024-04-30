<?php
/**
 * The Avatar Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Avatar;

use Wapuugotchi\Avatar\Handler\AvatarHandler;
use Wapuugotchi\Avatar\Handler\BubbleHandler;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Manager
 */
class Manager {
	const PREVENT_AVATAR_DISPLAY = array( 'post.php', 'toplevel_page_wapuugotchi' );

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
	}

	/**
	 * Initialization Log
	 *
	 * @param string $hook_suffix The internal page name.
	 *
	 * @return void
	 */
	public function init( $hook_suffix ) {
		if ( ! in_array( $hook_suffix, self::PREVENT_AVATAR_DISPLAY, true ) ) {
			$this->load_scripts();
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 */
	private function load_scripts() {
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
