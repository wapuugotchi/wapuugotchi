<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding;

use Wapuugotchi\Onboarding\Handler\AvatarHandler;
use Wapuugotchi\Onboarding\Handler\PageHandler;
use function add_action;
use function sprintf;
use function wp_add_inline_script;
use function wp_enqueue_script;
use function wp_enqueue_style;
use function wp_json_encode;
use function wp_set_script_translations;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Log
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	/**
	 * Initialization Log
	 */
	public function init() {
		if ( isset( $_GET['onboarding_mode'] ) ) {
			PageHandler::load_tour_files();
			add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'enable_welcome_guides' ), 20 );
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 */
	public function load_scripts() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/onboarding.asset.php';
		wp_enqueue_style( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.js', $assets['dependencies'], $assets['version'], true );

		wp_add_inline_script(
			'wapuugotchi-onboarding',
			sprintf(
				"wp.data.dispatch('wapuugotchi/onboarding').__initialize(%s)",
				wp_json_encode(
					array(
						'next_page'   => Helper::get_next_page_path(),
						'page_config' => Helper::get_current_page_item_list(),
						'index'       => Helper::get_first_index_of_current_page(),
						'avatar'      => AvatarHandler::get_avatar(),
						'animated'    => false,
					)
				)
			),
			'after'
		);

		wp_set_script_translations( 'wapuugotchi-onboarding', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	/**
	 * Disable welcome guides in Gutenberg.
	 */
	public function enable_welcome_guides() {
		wp_add_inline_script(
			'wp-data',
			"window.onload = function() {
		const selectPost = wp.data.select( 'core/edit-post' );
		const selectPreferences = wp.data.select( 'core/preferences' );
		const isFullscreenMode = selectPost.isFeatureActive( 'fullscreenMode' );
		const isWelcomeGuidePost = selectPost.isFeatureActive( 'welcomeGuide' );
		const isWelcomeGuideWidget = selectPreferences.get( 'core/edit-widgets', 'welcomeGuide' );

		if ( !isWelcomeGuideWidget ) {
			wp.data.dispatch( 'core/preferences' ).toggle( 'core/edit-widgets', 'welcomeGuide' );
		}

		if ( isFullscreenMode ) {
			wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' );
		}

		if ( !isWelcomeGuidePost ) {
			wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'welcomeGuide' );
		}
	}"
		);
	}
}
