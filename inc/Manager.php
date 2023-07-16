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
		$this->init_frontend_data();
	}

	/**
	 * Gets the config. Retrieves it from server if necessary.
	 */
	private function init_collection() {
		if ( $this->is_valid_collection() === false ) {
			delete_transient( 'wapuugotchi_categories' );
			delete_transient( 'wapuugotchi_items' );
			delete_transient( 'wapuugotchi_collection' );
			return $this->set_collection();
		}

		return true;
	}

	private function init_frontend_data() {
		if ( $this->is_valid_frontend_data() === false ) {
			delete_transient( 'wapuugotchi_categories' );
			delete_transient( 'wapuugotchi_items' );
			return $this->set_frontend_data();
		}

		return true;
	}

	private function is_valid_collection() {
		$collection = get_transient( 'wapuugotchi_collection' );
		if ( ! is_array( $collection ) || empty( $collection ) ) {
			return false;
		}

		if ( \get_transient( 'wapuugotchi_collection_checked_today' ) === false ) {
			\set_transient( 'wapuugotchi_collection_checked_today', true, Helper::getSecondsLeftUntilTomorrow() );
			return false;
		}

		return true;
	}

	private function is_valid_frontend_data() {
		$categories = get_transient( 'wapuugotchi_categories' );
		$item       = get_transient( 'wapuugotchi_items' );

		if ( ! is_array( $categories ) || empty( $categories ) ) {
			return false;
		}

		if ( ! is_array( $item ) || empty( $item ) ) {
			return false;
		}

		$keys = array_keys( $item );
		$md5 = md5( json_encode( get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true ) ) );
		if ( $keys[0] !== $md5 ) {
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
		$result     = array();
		$purchases  = get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true );
		$collection = get_transient( 'wapuugotchi_collection' );
		if ( ! is_array( $collection ) ) {
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
		$md5 = md5( json_encode( get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true ) ) );
		set_transient( 'wapuugotchi_items', array( $md5 => $items_collection ) );
		set_transient( 'wapuugotchi_categories', $category_collection );
	}

	private function resetAll() {
		delete_transient( 'wapuugotchi_collection' );
		delete_transient( 'wapuugotchi_categories' );
		delete_transient( 'wapuugotchi_items' );
		delete_transient( 'wapuugotchi_collection_checked_today' );

		delete_user_meta( get_current_user_id(), 'wapuugotchi__alpha' );
		delete_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha' );
		delete_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha' );
		delete_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha' );

	}

}
