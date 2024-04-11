<?php
/**
 * The Onboarding Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class Log
 */
class Onboarding {

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
		add_filter( 'login_redirect', array( $this, 'autostart' ), 10000, 3 );
	}

	/**
	 * Initialization Log
	 */
	public function init() {
		if ( isset( $_GET['onboarding_mode'] ) ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
			add_action( 'enqueue_block_editor_assets', array( $this, 'my_disable_welcome_guides' ), 20 );
		}
	}

	/**
	 * Load the Log scripts ( css and react ).
	 */
	public function load_scripts() {
		global $current_screen;
		$page_config = OnboardingManager::get_page_data( $current_screen->id );
		if ( empty( $page_config ) ) {
			return null;
		}

		$global_config = OnboardingManager::get_global_data();
		$first_index   = $this->get_first_index_of_page_config( $page_config );

		$assets = include_once WAPUUGOTCHI_PATH . 'build/onboarding.asset.php';
		wp_enqueue_style( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-onboarding', WAPUUGOTCHI_URL . 'build/onboarding.js', $assets['dependencies'], $assets['version'], true );

		wp_add_inline_script(
			'wapuugotchi-onboarding',
			sprintf(
				"wp.data.dispatch('wapuugotchi/onboarding').__initialize(%s)",
				wp_json_encode(
					array(
						'next_page'   => OnboardingManager::get_next_page_by_current_page( $current_screen->id ),
						'page_config' => isset( $page_config['item_list'] ) ? $page_config['item_list'] : null,
						'index'       => false !== $first_index ? $first_index : null,
						'wapuu'       => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ),
						'items'       => Helper::get_items(),
						'animated'    => false,
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-onboarding', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
		\update_option( 'wapuugotchi_onboarding_autostart_executedf', '1' );
	}

	/**
	 * Get the first index of the page config.
	 *
	 * @param array $page_config The page config.
	 */
	private function get_first_index_of_page_config( $page_config = null ) {
		if ( empty( $page_config['item_list'] ) ) {
			return false;
		}

		$config_keys = array_keys( $page_config['item_list'] );
		if ( count( $config_keys ) < 1 ) {
			return false;
		}

		return array_keys( $page_config['item_list'] )[0];
	}

	/**
	 * Get the page config.
	 *
	 * @param string $current_screen The current screen.
	 */
	private function get_page_config( $current_screen = 'none' ) {
		$config = $this->get_global_config();
		return isset( $config[ $current_screen ] ) ? $config[ $current_screen ] : array();
	}

	/**
	 * Get the global config.
	 */
	private function get_global_config() {
		return json_decode( file_get_contents( dirname( __DIR__, 2 ) . '/config/onboarding/tour.json' ), true );
	}

	/**
	 * Autostart the onboarding.
	 *
	 * @param string $redirect_to The redirect to.
	 * @param string $request The request.
	 * @param string $user The user.
	 */
	public function autostart( $redirect_to, $request, $user ) {
		if ( \get_option( 'wapuugotchi_onboarding_autostart_executedf' ) === '1' ) {
			return $redirect_to;
		}

		if ( is_a( $user, 'WP_User' ) && user_can( $user, 'manage_options' ) ) {
				return home_url( '/wp-admin/admin.php?page=wapuugotchi-onboarding&onboarding_mode=true' );
		}
		return $redirect_to;
	}

	/**
	 * Disable welcome guides in Gutenberg.
	 */
	public function my_disable_welcome_guides() {
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
