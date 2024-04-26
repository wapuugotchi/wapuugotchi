<?php
/**
 * The Alive Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Alive;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Manager
 */
class Manager {
	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Load the Log scripts ( css and react ).
	 *
	 * @return void
	 */
	public function load_scripts() {
	}
}
