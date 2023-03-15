<?php

namespace Ionos\Wapuugotchi;

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
		wp_enqueue_script( 'wapuugotchi-shop', '/wp-content/plugins/wapuugotchi/dist/bundle.js', [ 'jquery', 'wp-element' ], wp_rand(), true );
		wp_localize_script( 'wapuugotchi-shop', 'wpPluginParam', [
			'unlockedCollection' => json_decode( file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/unlockedCollection.json' ) ),
			'lockedCollection'   => json_decode( file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/lockedCollection.json' ) ),
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
			$config = json_decode( file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/default.json' ), true );
		}

		if ( ! empty( $config['char'] ) ) {
			$dom_elements = '';
			$collection   = array_merge_recursive(
				json_decode( file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/unlockedCollection.json' ), true ),
				json_decode( file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/lockedCollection.json' ), true )
			);

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
}