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

require_once 'vendor/autoload.php';

use _Plugin0\Options;
use _Plugin0\Updater;
use _Plugin0\Warning;

define( 'WAPUUGOTCHI_FILE', __FILE__ );
define( 'WAPUUGOTCHI_DIR', __DIR__ );
define( 'WAPUUGOTCHI_BASE', plugin_basename( __FILE__ ) );
$autoloader = __DIR__ . '/vendor/autoload.php';
if ( is_readable( $autoloader ) ) {
    require_once $autoloader;
}

/**
 * Init plugin.
 *
 * @return void
 */
function init() {
    Options::set_tenant_and_plugin_name('ionos', 'mops');

    new Updater();
    new Warning( 'wapuugotchi' );
	new Api();

	new Manager();
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