<?php
/**
 * Load the WapuuGotchi integrations.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Integration;

if ( ! \defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Initialize the WapuuGotchi integrations.
 */
function plugin_init() {
	/**
	 * Adds ActivityPub support.
	 *
	 * This class handles the compatibility with the ActivityPub plugin,
	 * adding Wapuu actors to the Fediverse.
	 *
	 * @see https://wordpress.org/plugins/activitypub/
	 */
	if ( \defined( 'ACTIVITYPUB_PLUGIN_DIR' ) ) {
		ActivityPub\Manager::init();
	}
}
\add_action( 'plugins_loaded', __NAMESPACE__ . '\plugin_init', 20 );
