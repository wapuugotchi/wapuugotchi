<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Hunt {


	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
	}

	public function init( $hook_suffix ) {
		if ( $hook_suffix === 'wapuugotchi_page_wapuugotchi-hunt' ) {
			$this->load_scripts();
		}
	}

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
