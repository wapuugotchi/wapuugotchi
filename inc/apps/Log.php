<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Log {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
	}

	public function init( $hook_suffix ) {
		if ( $hook_suffix === 'wapuugotchi_page_wapuugotchi-log' ) {
			$this->load_scripts();
		}
	}

	public function load_scripts() {
		$assets = require_once WAPUUGOTCHI_PATH . 'build/quest-log.asset.php';
		wp_enqueue_style( 'wapuugotchi-log', WAPUUGOTCHI_URL . 'build/quest-log.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-log', WAPUUGOTCHI_URL . 'build/quest-log.js', $assets['dependencies'], $assets['version'], true );
		wp_add_inline_script(
			'wapuugotchi-log',
			'window.extWapuugotchiLogData = ' . wp_json_encode( array() ),
			'before'
		);
	}

}
