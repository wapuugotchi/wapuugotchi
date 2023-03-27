<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Menu {
	public function __construct() {
		add_action( 'admin_menu', [ $this, 'create_menu_page' ] );
	}

	public function create_menu_page() {
		$capability = 'manage_options';
		$slug       = 'wapuugotchi';

		add_menu_page(
			__( 'Wapuugotchi', 'wapuugotchi' ),
			__( 'Wapuugotchi', 'wapuugotchi' ),
			$capability,
			$slug,
			[ $this, 'menu_page_template' ],
			'dashicons-buddicons-activity'
		);
	}

	public function menu_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-app"></div></div>';
	}
}
