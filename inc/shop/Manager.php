<?php
/**
 * The Customizer Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop;

use Exception;
use Wapuugotchi\Shop\Handler\AvatarHandler;
use Wapuugotchi\Shop\Handler\BalanceHandler;
use Wapuugotchi\Shop\Handler\CategoryHandler;
use Wapuugotchi\Shop\Handler\ItemHandler;
use function add_action;
use function add_filter;
use function sprintf;
use function wp_add_inline_script;
use function wp_enqueue_script;
use function wp_enqueue_style;
use function wp_json_encode;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Customizer
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
		add_filter( 'wapuugotchi_avatar', array( $this, 'modify_avatar' ), 10, 1 );
	}

	/**
	 * Initialization Log
	 *
	 * @param string $hook_suffix The internal page name.
	 *
	 * @return void
	 * @throws Exception If the asset file is not found.
	 */
	public function init( $hook_suffix ) {
		if ( 'toplevel_page_wapuugotchi' === $hook_suffix ) {
			$this->load_scripts();
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 * @throws Exception If the asset file is not found.
	 */
	public function load_scripts() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/shop.asset.php';
		wp_enqueue_style( 'wapuugotchi-shop', WAPUUGOTCHI_URL . 'build/shop.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-shop', WAPUUGOTCHI_URL . 'build/shop.js', $assets['dependencies'], $assets['version'], true );
		wp_add_inline_script(
			'wapuugotchi-shop',
			sprintf(
				"wp.data.dispatch('wapuugotchi/shop').__initialize(%s)",
				wp_json_encode(
					array(
						'categories'       => CategoryHandler::get_categories(),
						'selectedCategory' => CategoryHandler::MAIN_CATEGORY,
						'items'            => ItemHandler::get_items(),
						'balance'          => BalanceHandler::get_balance(),
						'wapuu'            => AvatarHandler::get_avatar_config(),
						'itemDetail'       => null,
					)
				)
			)
		);
	}

	/**
	 * Modify the avatar.
	 *
	 * @param string $avatar The avatar.
	 *
	 * @return string
	 */
	public function modify_avatar( $avatar ) {
		$svg = AvatarHandler::get_avatar_svg();
		if ( $svg ) {
			$avatar = $svg;
		}

		return $avatar;
	}
}
