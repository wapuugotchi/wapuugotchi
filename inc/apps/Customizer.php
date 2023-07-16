<?php

namespace Wapuugotchi\Wapuugotchi;

use Extendify\Config;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Customizer {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
	}

	public function init( $hook_suffix ) {
		if ( $hook_suffix === 'toplevel_page_wapuugotchi' ) {
			$this->load_scripts();
		}
	}

	public function load_scripts() {
		$assets = require_once WAPUUGOTCHI_PATH . 'build/customizer.asset.php';
		wp_enqueue_style( 'wapuugotchi-shop', WAPUUGOTCHI_URL . 'build/customizer.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-shop', WAPUUGOTCHI_URL . 'build/customizer.js', $assets['dependencies'], $assets['version'], true );
		wp_add_inline_script(
			'wapuugotchi-shop',
			sprintf(
				"wp.data.dispatch('wapuugotchi/wapuugotchi').__initialize(%s)",
				json_encode(
					array(
						'categories' => \get_transient( 'wapuugotchi_categories' ),
						'items'      => \get_transient( 'wapuugotchi_items' ),
						'balance'    => get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ),
						'wapuu'      => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ),
						'message'    => false,
						'intention'  => false,
						'restBase'   => Helper::get_rest_api(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-shop', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

}
