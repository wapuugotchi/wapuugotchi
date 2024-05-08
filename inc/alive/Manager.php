<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Alive;

use Wapuugotchi\Alive\Handler\AnimationHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 */
class Manager {
	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_avatar', array( AnimationHandler::class, 'extract_animations' ), PHP_INT_MAX, 1 );
		\add_action( 'animations_extracted', array( $this, 'add_animations' ) );
	}

	/**
	 * Init plugin.
	 *
	 * @return void
	 */
	public function add_animations( $animations ) {
		\add_action( 'admin_enqueue_scripts', function () use ( $animations ) {
			/*************** DumpDebugDie ***************/
			echo '<pre>';
			wp_die( var_dump( $animations ) );
			echo '</pre>';
			/*************** DumpDebugDie ***************/
		}, 20 );

	}
}
