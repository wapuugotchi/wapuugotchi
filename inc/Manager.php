<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Manager {
	const COLLECTION_STRUCTURE = array(
		'fur'   => '',
		'balls' => '',
		'caps'  => '',
		'items' => '',
		'coats' => '',
		'shoes' => '',
	);

	public function __construct() {
		add_action( 'admin_init', array( $this, 'init' ) );
	}

	public function init( $hook_suffix ) {
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ) ) {
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi__alpha',
				file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/default.json' )
			);
		}
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ) ) ) {
			update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', 0 );
		}
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true ) ) ) {
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_purchases__alpha',
				array()
			);
		}

		$this->set_frontend_data();

		add_action( 'wapuugotchi_add_source', array( $this, 'add_source' ), 10, 1 );


	}

	/**
	 * Adds a new source to the collection.
	 */
	public function add_source( $url ) {
		$sources = array_keys( get_transient( 'wapuugotchi_collection' ) );

		if ( in_array( md5( $url ), $sources ) ) {
			return;
		}

		$this->set_collection( $url );
	}

	/**
	 * Gets the config. Retrieves it from server if necessary.
	 */
	private function get_collection( $file = null ) {
		// toDo: refactor the following code to use the new collection format
		if ( $file ) {
			return json_decode(
				file_get_contents( \plugin_dir_path( __DIR__ ) . 'config/' . $file ),
				true
			);
		}

		if ( get_transient( 'wapuugotchi_collection' ) === false ) {
			$this->set_collection();
		}

		return get_transient( 'wapuugotchi_collection' );
	}

	/**
	 * Retrieves the collection from the remote server and sets it as transient.
	 */
	private function set_collection( $url = 'https://api.wapuugotchi.com/collection' ) {
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

		$totalConfig                = get_transient( 'wapuugotchi_collection' );
		$totalConfig[ md5( $url ) ] = $config;

		set_transient( 'wapuugotchi_collection', $totalConfig, 60 * 60 * 24 );
		$this->set_frontend_data();
	}

	/**
	 * Checks if collection is valid.
	 *
	 * @param object $config Collection config.
	 */
	private function is_collection_valid( $config ) {
		return true;
	}

	/**
	 * Takes the collection, prepares the categories and item collection for the frontend, and sets them as transients.
	 */
	private function set_frontend_data() {
		if ( get_transient( 'wapuugotchi_categories' ) !== false &&
		     get_transient( 'wapuugotchi_items' ) !== false
		) {
			return;
		}
		$collections = array();
		$purchases   = get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true );
		foreach ( $this->get_collection() as $hash => $object ) {
			$collections = $object->collections;
		}

		$category_collection = self::COLLECTION_STRUCTURE;
		$items_collection    = array();
		foreach ( $collections as $collection ) {
			if ( ! isset( $category_collection[ $collection->slug ] ) ) {
				continue;
			}

			$category_collection[ $collection->slug ] = array(
				'caption' => $collection->caption,
				'image'   => $collection->image,
			);

			foreach ( $collection->items as $item ) {
				if ( $item->meta->deactivated ) {
					continue;
				}
				if ( in_array( $item->meta->key, $purchases ) ) {
					$item->meta->price    = 0;
					$item->meta->priority = - 1 * ( array_search( $item->meta->key, $purchases ) + 10000 );
				}
				$items_collection[ $collection->slug ][ $item->meta->key ] = $item;
			}
		}

		set_transient( 'wapuugotchi_categories', $category_collection, DAY_IN_SECONDS );
		set_transient( 'wapuugotchi_items', $items_collection, DAY_IN_SECONDS );
	}

	/**
	 * Formats the REST API url
	 *
	 * @return string
	 */
	public static function get_rest_api() {
		$api      = get_rest_url( null, Api::REST_BASE );
		$find     = 'wp-json';
		$position = strpos( $api, $find );
		if ( $position === false ) {
			return $api;
		}

		return substr( $api, $position + strlen( $find ) );
	}

	private function resetAll() {
		delete_transient( 'wapuugotchi_categories' );
		delete_transient( 'wapuugotchi_items' );
		delete_transient( 'wapuugotchi_collection' );
		update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', 200 );
		update_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', array(
			'3392a397-22d1-44d0-b575-f31850012769',
			'870cbca1-4448-43ae-b815-11e9c2617159'
		) );
		update_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', array() );
	}
}
