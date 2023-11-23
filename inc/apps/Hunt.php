<?php
/**
 * The Hunt Class.
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
class Hunt {

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
		if ( 'wapuugotchi_page_wapuugotchi-hunt' === $hook_suffix ) {
			$this->load_scripts();
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 */
	public function load_scripts() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/scavenger-hunt.asset.php';
		wp_enqueue_style( 'wapuugotchi-hunt', WAPUUGOTCHI_URL . 'build/scavenger-hunt.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-hunt', WAPUUGOTCHI_URL . 'build/scavenger-hunt.js', $assets['dependencies'], $assets['version'], true );
		wp_add_inline_script(
			'wapuugotchi-hunt',
			'window.extWapuugotchiHuntData = ' . wp_json_encode( array() ),
			'before'
		);

		\wp_set_script_translations( 'wapuugotchi-hunt', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	
}
