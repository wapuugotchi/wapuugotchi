<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Manager {
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

		$this->init_collection();

	}

	/**
	 * Gets the config. Retrieves it from server if necessary.
	 */
	private function init_collection() {
		$collection = get_transient( 'wapuugotchi_collection' );

		// leave if collection is still valid
		if ( is_array( $collection ) && !empty( $collection ) && get_transient( 'wapuugotchi_collection_checked_today' ) !== false ) {
			$keys = array_keys( $collection );
			if( $keys[0] === md5( Helper::COLLECTION_API_URL && $this->validate_frontend_data() ) ) {
				return true;
			}
		} else {
			delete_transient( 'wapuugotchi_collection' );
			delete_transient( 'wapuugotchi_categories' );
			delete_transient( 'wapuugotchi_items' );

			if ( $this->set_collection() === false ) {
				return false;
			}

			if ( $this->set_frontend_data() === false ) {
				return false;
			}

			return set_transient('wapuugotchi_collection_checked_today', true, Helper::getSecondsLeftUntilTomorrow() );
		}

	}

	private function validate_frontend_data() {
		if ( get_transient( 'wapuugotchi_categories' ) === false || get_transient( 'wapuugotchi_items' ) === false )  {
			return false;
		}

		return true;
	}
	/**
	 * Retrieves the collection from the remote server and sets it as transient.
	 */
	private function set_collection() {
		$response = wp_remote_get( Helper::COLLECTION_API_URL );
		if ( is_wp_error( $response ) ) {
			return false;
		}

		$body = wp_remote_retrieve_body( $response );

		if ( empty( $body ) ) {
			return false;
		}

		$config = json_decode( $body );

		if ( empty( $config ) ) {
			return false;
		}

		$totalConfig[ md5( Helper::COLLECTION_API_URL ) ] = $config;
		return set_transient( 'wapuugotchi_collection', $totalConfig );

	}

	/**
	 * Takes the collection, prepares the categories and item collection for the frontend, and sets them as transients.
	 */
	private function set_frontend_data() {
		$result 	= array();
		$purchases  = get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true );
		$collection = get_transient( 'wapuugotchi_collection' );
		if( !is_array($collection)) {
			return;
		}

		foreach ( $collection as $object ) {
			$result = $object->collections;
		}

		$category_collection = Helper::COLLECTION_STRUCTURE;
		$items_collection    = array();
		foreach ( $result as $collection ) {
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

		set_transient( 'wapuugotchi_categories', $category_collection );
		set_transient( 'wapuugotchi_items', $items_collection );
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
		delete_transient( 'wapuugotchi_collection' );
		delete_transient( 'wapuugotchi_categories' );
		delete_transient( 'wapuugotchi_items' );
		delete_transient('wapuugotchi_collection_checked_today' );

		delete_user_meta( get_current_user_id(), 'wapuugotchi__alpha' );
		delete_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha' );
		delete_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha' );
		delete_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha' );

	}

}
