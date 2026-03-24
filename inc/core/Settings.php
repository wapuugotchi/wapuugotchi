<?php
/**
 * The Settings Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Settings
 */
class Settings {

	/**
	 * The REST base path.
	 */
	const REST_BASE = 'wapuugotchi/v1';

	/**
	 * The option key for plugin settings.
	 */
	const OPTION_KEY = 'wapuugotchi_settings';

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_add_submenu', array( $this, 'wapuugotchi_add_submenu' ), 30 );
		\add_action( 'rest_api_init', array( $this, 'create_rest_routes' ) );
		\add_action( 'load-wapuugotchi_page_wapuugotchi__settings', array( $this, 'init' ) );
	}

	/**
	 * Init page specific hooks.
	 *
	 * @return void
	 */
	public function init() {
		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Render the settings page template.
	 *
	 * @return void
	 */
	public static function settings_page_template() {
		echo '<div class="wrap"><div id="wapuugotchi-submenu__settings"></div></div>';
	}

	/**
	 * Add the settings submenu entry.
	 *
	 * @param array $submenus Array of submenus.
	 *
	 * @return array
	 */
	public function wapuugotchi_add_submenu( $submenus ) {
		$submenus[] = array(
			'title'    => \__( 'Settings', 'wapuugotchi' ),
			'slug'     => 'wapuugotchi__settings',
			'callback' => 'Wapuugotchi\Core\Settings::settings_page_template',
		);

		return $submenus;
	}

	/**
	 * Get all registered feature definitions via filter.
	 *
	 * Each entry must contain at least 'key' and 'default'.
	 *
	 * @return array
	 */
	public static function get_registered_features() {
		$features = \apply_filters( 'wapuugotchi_register_settings', array() );
		if ( ! \is_array( $features ) ) {
			return array();
		}

		$result = array();
		foreach ( $features as $feature ) {
			if ( ! empty( $feature['key'] ) ) {
				$result[] = $feature;
			}
		}

		return $result;
	}

	/**
	 * Get current settings, merging saved values with registered defaults.
	 *
	 * @return array
	 */
	public static function get_current_settings() {
		$features = self::get_registered_features();
		$saved    = \get_option( self::OPTION_KEY, array() );

		$result = array();
		foreach ( $features as $feature ) {
			$key            = $feature['key'];
			$default        = $feature['default'] ?? true;
			$result[ $key ] = $saved[ $key ] ?? $default;
		}

		return $result;
	}

	/**
	 * Enqueue settings scripts and styles.
	 *
	 * @return void
	 * @throws \Exception If the asset file is not found.
	 */
	public function load_scripts() {
		$asset_path = WAPUUGOTCHI_PATH . 'build/settings.asset.php';
		if ( ! \file_exists( $asset_path ) ) {
			throw new \Exception( 'Settings assets not found. Run npm run build.' );
		}

		$assets = include_once $asset_path;

		\wp_enqueue_style( 'wapuugotchi-settings', WAPUUGOTCHI_URL . 'build/settings.css', array( 'wp-components' ), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-settings', WAPUUGOTCHI_URL . 'build/settings.js', $assets['dependencies'], $assets['version'], true );
		\wp_add_inline_script(
			'wapuugotchi-settings',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/settings').__initialize(%s)",
				\wp_json_encode(
					array(
						'features' => self::get_registered_features(),
						'settings' => self::get_current_settings(),
						'nonce'    => \wp_create_nonce( 'wapuugotchi_settings' ),
					)
				)
			),
			'after'
		);
	}

	/**
	 * Register REST routes.
	 *
	 * @return void
	 */
	public function create_rest_routes() {
		\register_rest_route(
			self::REST_BASE,
			'/settings/save',
			array(
				'methods'             => 'POST',
				'callback'            => array( $this, 'save_settings' ),
				'permission_callback' => array( $this, 'get_settings_permissions' ),
			)
		);
	}

	/**
	 * Permission check for settings endpoints.
	 *
	 * @return bool
	 */
	public function get_settings_permissions() {
		return \current_user_can( 'manage_options' );
	}

	/**
	 * Save settings via REST API.
	 *
	 * @param \WP_REST_Request $req The request object.
	 *
	 * @return \WP_REST_Response
	 */
	public function save_settings( $req ) {
		$body = \json_decode( $req->get_body() );

		if ( ! isset( $body->nonce ) ) {
			return \rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'nonce not set' ), 400 )
			);
		}

		if ( ! \wp_verify_nonce( $body->nonce, 'wapuugotchi_settings' ) ) {
			return \rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'nonce not valid' ), 400 )
			);
		}

		if ( ! isset( $body->settings ) || ! \is_object( $body->settings ) ) {
			return \rest_ensure_response(
				new \WP_REST_Response( array( 'error' => 'settings not set' ), 400 )
			);
		}

		$allowed_keys = \array_column( self::get_registered_features(), 'key' );
		$sanitized    = array();
		foreach ( $allowed_keys as $key ) {
			if ( isset( $body->settings->$key ) ) {
				$sanitized[ $key ] = (bool) $body->settings->$key;
			}
		}

		\update_option( self::OPTION_KEY, $sanitized );

		return \rest_ensure_response(
			new \WP_REST_Response( array( 'status' => '200' ), 200 )
		);
	}
}
