<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Log
 */
class Onboarding {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
	}

	/**
	 * Initialization Log
	 *
	 * @param string $hook_suffix The internal page name.
	 *
	 * @return void
	 */
	public function init() {
		if ( isset( $_GET['onboarding_mode'] ) ) {
			$this->load_scripts();
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 */
	public function load_scripts() {
		global $current_screen;
		$page_config    = $this->get_page_config( $current_screen->id );
		$global_config  = $this->get_global_config();
		$first_index    = $this->getFirstIndexOfPageConfig( $page_config);
		$assets = include_once WAPUUGOTCHI_PATH . 'build/onboarding.asset.php';
		wp_enqueue_style( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.js', $assets['dependencies'], $assets['version'], true );

		wp_add_inline_script(
			'wapuugotchi-onboarding',
			sprintf(
				"wp.data.dispatch('wapuugotchi/onboarding').__initialize(%s)",
				wp_json_encode(
					array(
						'page_name'     => $current_screen->id,
						'global_config' => $global_config,
						'page_config'   => isset( $page_config['data']) ?$page_config['data']: null,
						'index'         => $first_index !== false ?$first_index: null,
						'wapuu'         => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ),
						'items'         => Helper::get_items(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-onboarding', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	private function getFirstIndexOfPageConfig($page_config = null) {
		if ( empty( $page_config['data'] )) {
			return false;
		}

		$configKeys = array_keys( $page_config['data'] );
		if (count($configKeys) < 1) {
			return false;
		}

		return array_keys( $page_config['data'] )[0];
	}

	private function get_page_config( $current_screen = 'none' ) {
		$config = $this->get_global_config();
		return isset( $config[$current_screen]) ?  $config[$current_screen] : [];
	}

	private function get_global_config() {
		return json_decode( file_get_contents( dirname( __DIR__, 2 ) . '/config/onboarding/tour.json' ), true );
	}
}
