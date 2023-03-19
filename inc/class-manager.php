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

		add_action( 'wapuugotchi_add_source', [ $this, 'add_source' ], 10, 1 );
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

    wp_add_inline_script( 'wapuugotchi-shop', 
    sprintf("wp.data.dispatch('wapuugotchi/wapuugotchi').setCollections(%s)", json_encode( 
      $this->get_collection()
     )), 'after' );  
	}

	public function load_home_scripts() {
		$assets = require_once __DIR__ . '/../build/wapuugotchi.asset.php';
		\wp_enqueue_style( 'wapuugotchi-page', plugins_url( 'build/wapuugotchi.css', __DIR__ ), array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-page', plugins_url( 'build/wapuugotchi.js', __DIR__ ), $assets['dependencies'], $assets['version'], true );
		\wp_localize_script( 'wapuugotchi-page', 'wpPluginParam', [
			'wapuu' => $this->get_dom_tags(),
			'nonce' => wp_create_nonce( 'wp_rest' ),
		] );
	}

	private function get_dom_tags() {
		$config = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi', true ), true );
		if ( empty( $config ) ) {
			$config = $this->get_collection();
		}

		if ( ! empty( $config['char'] ) ) {
			$dom_elements = '';
			$collection   = array_merge_recursive(
				$this->get_collection( 'lockedCollection.json' ),
				$this->get_collection( 'unlockedCollection.json' ),
			);

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
	 * Adds a new source to the collection.
	 */
	public function add_source( $url ) {
		$sources = array_keys(get_transient( 'wapuugotchi_collection' ) );

		if ( in_array( md5($url), $sources ) ) {
			return;
		}

		$this->set_collection( $url );
		
	}

	/**
	 * Gets the config. Retrieves it from server if necessary.
	 */
	private function get_collection( $file = null ){
		// toDo: refactor the following code to use the new collection format
		if( $file ) {
			return  json_decode(
				file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/' . $file ), true
			);
		}
		
		if (1 || empty( get_transient( 'wapuugotchi_collection' ) ) ) {
			$this->set_collection();
		}
		
		return get_transient( 'wapuugotchi_collection' );
	}

	/**
	 * Retrieves the collection from the remote server and sets it as transient.
	 */
	private function set_collection( $url =  'https://api.wapuugotchi.com/collection' ) {
	
		$response = wp_remote_get( $url );
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

		$totalConfig = get_transient( 'wapuugotchi_collection' );
		$totalConfig[ md5( $url ) ] = $config;

		set_transient( 'wapuugotchi_collection', $totalConfig, 60 * 60 * 24 );
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
