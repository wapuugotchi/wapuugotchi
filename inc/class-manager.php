<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Manager {
	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	public function init() {
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi', true ) ) ) {
			update_user_meta( get_current_user_id(), 'wapuugotchi',
				file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/default.json' )
			);
		}
			if ( get_admin_page_title() === 'Wapuugotchi' ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_shop_scripts' ) );
		} elseif (  parse_url( get_admin_url(), PHP_URL_PATH ) === '/wp-admin/' ) {
			add_action( 'admin_enqueue_scripts', array( $this, 'load_home_scripts' ) );
		}
	}

	public function load_shop_scripts() {
		$assets = require_once __DIR__ . '/../build/index.asset.php';
		wp_enqueue_style( 'wapuugotchi-shop', plugins_url( 'build/index.css', __DIR__ ), [], $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-shop', plugins_url( 'build/index.js', __DIR__ ), $assets['dependencies'], $assets['version'], true );

		wp_localize_script( 'wapuugotchi-shop', 'wpPluginParam', [
			'unlockedCollection' => $this->get_collection( 'unlockedCollection.json'),
			'lockedCollection'   => $this->get_collection( 'lockedCollection.json' ),
			'wapuu'              => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi', true ) ),
			'apiUrl'             => get_rest_url( null, 'wapuugotchi' ),
			'nonce'              => wp_create_nonce( 'wp_rest' ),
		] );
	}

	public function load_home_scripts() {
		\wp_enqueue_style( 'wapuugotchi-page', plugins_url( 'css/wapuugotchi.css', __DIR__ ), array(), filemtime( plugin_dir_path( __DIR__ ) . 'css/wapuugotchi.css' ) );
		\wp_enqueue_script( 'wapuugotchi-page', '/wp-content/plugins/wapuugotchi/js/wapuugotchi.js', array(), '', true );
		\wp_localize_script( 'wapuugotchi-page', 'wpPluginParam', [
			'wapuu' => $this->get_dom_tags(),
		] );
	}

	private function get_dom_tags() {
		$config = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi', true ), true );
		if ( empty( $config ) ) {
			$config = $this->get_collection();
		}

		if ( ! empty( $config['char'] ) ) {
			$dom_elements = '';
			$collection   = $this->get_collection();

			// todo: Adapt following code to new collection format
			foreach ( $config['char'] as $key => $category ) {
				if ( ! empty( $category['key'] ) && ! empty( $collection[ $key ] ) ) {
					foreach ( $collection[ $key ] as $items ) {
						if ( isset( $items['key'] ) && in_array( $items['key'], $category['key'] ) ) {
							$dom_elements .= '<img class="wapuugotchi__image" src="' . $items['path'] . '">';
						}
					}
				}
			}

			return $dom_elements;
		}
	}

	/**
	 * Gets the config. Retrieves it from server if necessary.
	 */
	private function get_collection( $file ){
		// toDo: refactor the following code to use the new collection format
		return  json_decode(
			file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/' . $file ) 
		);
		
		if (empty( get_transient( 'wapuugotchi_collection' ) ) ) {
			$this->set_collection();
		}
		
		return get_transient( 'wapuugotchi_collection' );
	}

	/**
	 * Retrieves the collection from the remote server and sets it as transient.
	 */
	private function set_collection(  ) {
		$response = wp_remote_get( 'https://api.wapuugotchi.com/collection.json' );
		if ( is_wp_error( $response ) ) {
			return;
		}

		$body = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {
			return;
		}

		$config = json_decode( $body );
		if ( empty( $config ) ) {
			return;
		}

		if ( ! $this->is_collection_valid( $config ) ) {
			return;
		}

		set_transient( 'wapuugotchi_collection', $config, 60 * 60 * 24 );
	}

	/**
	 * Checks if collection is valid.
	 *
	 * @param object $config Collection config.
	 */
	private function is_collection_valid( $config ) {
		return true;
	}
}
