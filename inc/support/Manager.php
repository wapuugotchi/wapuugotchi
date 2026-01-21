<?php
/**
 * Entry point for the Support feature.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Support;

use Wapuugotchi\Support\Data\Cards;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 */
class Manager {

	/**
	 * Register hooks for the support feature.
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 20 );
		\add_action( 'load-wapuugotchi_page_wapuugotchi__support', array( $this, 'init' ), 100 );
	}

	/**
	 * Init page specific hooks.
	 *
	 * @return void
	 */
	public function init() {
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Enqueue the support scripts and styles.
	 *
	 * @return void
	 * @throws \Exception If the asset file is not found.
	 */
	public function load_scripts() {
		$asset_path = WAPUUGOTCHI_PATH . 'build/support.asset.php';
		if ( ! \file_exists( $asset_path ) ) {
			throw new \Exception( 'Support assets not found. Run npm run build.' );
		}

		$assets = include_once $asset_path;

		\wp_enqueue_style( 'wapuugotchi-support', WAPUUGOTCHI_URL . 'build/support.css', array( 'wp-components' ), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-support', WAPUUGOTCHI_URL . 'build/support.js', $assets['dependencies'], $assets['version'], true );
		\wp_add_inline_script(
			'wapuugotchi-support',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/support').__initialize(%s)",
				\wp_json_encode(
					array(
						'cards' => Cards::get_cards(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-support', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}
}
