<?php
/**
 * Plugin Name:  Wapuugotchi
 * Plugin URI:   <PLUGIN_URI>
 * Description:  <AUTHOR>
 * Version:      <VERSION>
 * License:      GPLv2 or later
 * Author:       <AUTHOR>
 * Author URI:   <AUTHOR_URI>
 * Text Domain:  wapuugotchi
 * Domain Path:  /languages
 */
namespace Ionos\Wapuugotchi;

/**
 * Init plugin.
 *
 * @return void
 */
function init() {

	require_once 'inc/class-api.php';
	new Api();

	require_once 'inc/class-manager.php';
	new Manager();

	require_once 'inc/class-menu.php';
	new Menu();
}

\add_action( 'plugins_loaded', __NAMESPACE__ . '\init' );

/**
 * Plugin translation.
 *
 * @return void
 */
function load_textdomain() {
	if ( false !== \strpos( \plugin_dir_path( __FILE__ ), 'mu-plugins' ) ) {
		\load_muplugin_textdomain(
			'wapuugotchi',
			\basename( \dirname( __FILE__ ) ) . '/languages'
		);
	} else {
		\load_plugin_textdomain(
			'wapuugotchi',
			false,
			\dirname( \plugin_basename( __FILE__ ) ) . '/languages/'
		);
	}
}
\add_action( 'init', __NAMESPACE__ . '\load_textdomain' );