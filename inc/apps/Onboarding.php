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
	public function init( $hook_suffix ) {
		if ( isset( $_GET['onboarding'] ) ) {
			$this->load_scripts( $hook_suffix );
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 */
	public function load_scripts( $current_page ) {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/onboarding.asset.php';
		wp_enqueue_style( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.js', $assets['dependencies'], $assets['version'], true );
		wp_add_inline_script(
			'wapuugotchi-onboarding',
			sprintf(
				"wp.data.dispatch('wapuugotchi/onboarding').__initialize(%s)",
				wp_json_encode(
					array(
						'full_config' => $this->get_config(),
						'config' => $this->get_page_config( $current_page ),
						'page'   => $current_page,
						'current' => 'das aktuelle Element',
						'next' => 'das nächste Element',
						'last' => 'das letzte Element'
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-onboarding', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	private function get_page_config($current_page = 'none') {
		$config = $this->get_config();
		if (isset( $config[$current_page])) {
			return $config[$current_page];
		} else {
			return [];
		}
	}

	private function get_config() {
		return json_decode( file_get_contents( dirname( __DIR__, 2 ) . '/config/onboarding/tour.json' ), true );
	}
}
