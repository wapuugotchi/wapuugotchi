<?php
/**
 * Entry point for the shop feature. Manages the shop menu and the shop api.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Shop;

use Wapuugotchi\Shop\Handler\AvatarHandler;
use Wapuugotchi\Shop\Handler\BalanceHandler;
use Wapuugotchi\Shop\Handler\CategoryHandler;
use Wapuugotchi\Shop\Handler\ItemHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Customizer
 */
class Manager {

	/**
	 * Entry point for the shop feature. Manages the shop menu and the shop api.
	 */
	public function __construct() {
		AvatarHandler::init();
		BalanceHandler::init();

		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 10 );
		\add_action( 'rest_api_init', array( Api::class, 'create_rest_routes' ) );
		\add_action( 'load-wapuugotchi_page_wapuugotchi__shop', array( $this, 'init' ), 100 );
		\add_filter( 'wapuugotchi_avatar', array( $this, 'modify_avatar' ), 10, 1 );
	}

	/**
	 * Init the shop, load the scripts.
	 *
	 * @return void
	 */
	public function init() {
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Enqueue the shop scripts and styles.
	 *
	 * @return void
	 * @throws \Exception If the asset file is not found.
	 */
	public function load_scripts() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/shop.asset.php';
		\wp_enqueue_style( 'wapuugotchi-shop', WAPUUGOTCHI_URL . 'build/shop.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-shop', WAPUUGOTCHI_URL . 'build/shop.js', $assets['dependencies'], $assets['version'], true );
		\wp_add_inline_script(
			'wapuugotchi-shop',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/shop').__initialize(%s)",
				\wp_json_encode(
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
	 * Return the avatar from the avatar handler or the default avatar.
	 *
	 * @param string $avatar The avatar.
	 *
	 * @return string
	 */
	public function modify_avatar( $avatar ) {
		$svg = AvatarHandler::get_avatar_svg();
		if ( $svg ) {
			return $svg;
		}

		return $avatar;
	}
}
