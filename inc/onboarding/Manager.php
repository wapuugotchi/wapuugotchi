<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding;

use Wapuugotchi\Onboarding\Data\TourOrder;
use Wapuugotchi\Onboarding\Handler\AvatarHandler;
use Wapuugotchi\Onboarding\Handler\PageHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Log
 */
class Manager {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		if ( false === Helper::is_valid_version() ) {
			return;
		}

		\add_filter( 'wapuugotchi_add_submenu', array( Menu::class, 'wapuugotchi_add_submenu' ), 30 );
		\add_action( 'current_screen', array( Menu::class, 'force_redirect_to_dashboard' ) );
		\add_action( 'admin_init', array( $this, 'init' ), 100 );
	}

	/**
	 * Initialization Log
	 */
	public function init() {
		if ( ! isset( $_GET['onboarding_mode'] ) ) {
			return;
		}

		\add_filter( 'wapuugotchi_onboarding_tour_files', array( TourOrder::class, 'add_wapuugotchi_filter' ), 1 );
		PageHandler::load_tour_files();
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
		\add_action( 'enqueue_block_editor_assets', array( $this, 'enable_welcome_guides' ), 20 );
	}

	/**
	 * Load the Log scripts ( css and react ).
	 */
	public function load_scripts() {
		$assets = include_once WAPUUGOTCHI_PATH . 'build/onboarding.asset.php';
		\wp_enqueue_style( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.js', $assets['dependencies'], $assets['version'], true );

		\wp_add_inline_script(
			'wapuugotchi-onboarding',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/onboarding').__initialize(%s)",
				\wp_json_encode(
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

		\wp_set_script_translations( 'wapuugotchi-onboarding', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	/**
	 * Force autostart of the onboarding.
	 * This is used to force to autostart of the onboarding.
	 *
	 * @return void
	 */
	public function force_autostart() {
		if ( ! empty( \get_user_meta( \get_current_user_id(), 'wapuugotchi_onboarding_autostart_executed', true ) ) ) {
			return;
		}

		\update_user_meta( \get_current_user_id(), 'wapuugotchi_onboarding_autostart_executed', true );
		\wp_safe_redirect( \home_url( 'wp-admin/admin.php?page=wapuugotchi__tour' ) );
		exit();
	}

	/**
	 * Disable welcome guides in Gutenberg.
	 */
	public function enable_welcome_guides() {
		\wp_add_inline_script(
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
