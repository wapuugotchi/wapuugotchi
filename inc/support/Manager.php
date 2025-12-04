<?php
/**
 * Entry point for the Support feature.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Support;

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
						'cards' => $this->get_cards(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-support', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	/**
	 * Provide card data for the support page.
	 *
	 * @return array
	 */
	private function get_cards() {
		return array(
			array(
				'title'       => \__( '🤝 Contact us', 'wapuugotchi' ),
				'description' => \__( 'Questions, feedback, or need a hand with WapuuGotchi? Send us a note.', 'wapuugotchi' ),
				'meta'        => \__( 'Email: support@wapuugotchi.com', 'wapuugotchi' ),
				'button'      => array(
					'label' => \__( 'Send email', 'wapuugotchi' ),
					'href'  => 'mailto:support@wapuugotchi.com',
					'type'  => 'primary',
				),
			),
			array(
				'title'       => \__( '🐞 Found a bug?', 'wapuugotchi' ),
				'description' => \__( 'Oops, that should not happen. Help us squash it fast:', 'wapuugotchi' ),
				'list'        => array(
					\__( 'What were you trying to do?', 'wapuugotchi' ),
					\__( 'Steps to reproduce', 'wapuugotchi' ),
					\__( 'Your WordPress, PHP & WapuuGotchi versions', 'wapuugotchi' ),
				),
				'button'      => array(
					'label' => \__( 'Report a bug', 'wapuugotchi' ),
					'href'  => 'https://github.com/wapuugotchi/wapuugotchi/issues/new?type=bug',
					'type'  => 'secondary',
				),
			),
			array(
				'title'       => \__( '💡 Ideas & feature wishes', 'wapuugotchi' ),
				'description' => \__( 'Got an idea for new items, missions, or improvements? Tell us!', 'wapuugotchi' ),
				'button'      => array(
					'label' => \__( 'Share an idea', 'wapuugotchi' ),
					'href'  => 'https://github.com/wapuugotchi/wapuugotchi/issues/new?type=feature',
					'type'  => 'secondary',
				),
			),
			array(
				'title'       => \__( '💛 Support WapuuGotchi', 'wapuugotchi' ),
				'description' => \__( 'WapuuGotchi stays free, but art and graphics cost money. If you want, you can support us:', 'wapuugotchi' ),
				'highlight'   => true,
				'button'      => array(
					'label' => \__( 'Buy me a coffee', 'wapuugotchi' ),
					'href'  => 'https://www.buymeacoffee.com/wapuugotchi',
					'type'  => 'primary',
				),
			),
		);
	}
}
