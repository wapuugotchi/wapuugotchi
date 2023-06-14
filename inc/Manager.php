<?php

namespace Wapuugotchi\Wapuugotchi;

use Composer\Installers\Plugin;

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
//		delete_transient( 'wapuugotchi_categories' );
//		delete_transient( 'wapuugotchi_items' );
//		delete_transient( 'wapuugotchi_collection' );
//		update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', 1000);
//		update_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', array('3392a397-22d1-44d0-b575-f31850012769', '870cbca1-4448-43ae-b815-11e9c2617159'));
//		update_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', array());
//		update_user_meta( get_current_user_id(), 'wapuugotchi_confirmed_notifications__alpha', array());

		add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
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
			update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', 1000 );
		}
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi_purchases__alpha', true ) ) ) {
			update_user_meta(
				get_current_user_id(),
				'wapuugotchi_purchases__alpha',
				array(
					'3392a397-22d1-44d0-b575-f31850012769',
					'870cbca1-4448-43ae-b815-11e9c2617159',
				)
			);
		}
		if ( empty( get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ) ) ) {
			update_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', 1000 );
		}

		$this->set_frontend_data();
		$this->get_items_for_current_user();

		add_action( 'wapuugotchi_add_source', array( $this, 'add_source' ), 10, 1 );
		if ( $hook_suffix === 'toplevel_page_wapuugotchi' ) {
			$this->load_shop_scripts();
		} else if ( $hook_suffix === 'wapuugotchi_page_wapuugotchi-hunt' ) {
			$this->load_hunt_scripts();
		} else if ( $hook_suffix === 'wapuugotchi_page_wapuugotchi-quests' ) {
			$this->load_home_scripts();
		} else {
			$this->load_home_scripts();
		}
	}

	public function load_shop_scripts() {
		$assets = require_once __DIR__ . '/../build/customizer.asset.php';
		wp_enqueue_style( 'wapuugotchi-shop', plugins_url( 'build/customizer.css', __DIR__ ), array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-shop', plugins_url( 'build/customizer.js', __DIR__ ), $assets['dependencies'], $assets['version'], true );

		wp_add_inline_script(
			'wapuugotchi-shop',
			sprintf(
				"wp.data.dispatch('wapuugotchi/wapuugotchi').__initialize(%s)",
				json_encode(
					array(
						'categories' => \get_transient( 'wapuugotchi_categories' ),
						'items'      => \get_transient( 'wapuugotchi_items' ),
						'balance'    => get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ),
						'wapuu'      => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ),
						'message'    => false,
						'intention'  => false,
						'restBase'   => $this->get_rest_api(),
					)
				)
			),
			'after'
		);
	}

	public function load_hunt_scripts() {
		$assets = require_once __DIR__ . '/../build/scavenger-hunt.asset.php';
		wp_enqueue_style( 'wapuugotchi-hunt', plugins_url( 'build/scavenger-hunt.css', __DIR__ ), array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-hunt', plugins_url( 'build/scavenger-hunt.js', __DIR__ ), $assets['dependencies'], $assets['version'], true );

		wp_add_inline_script(
			'wapuugotchi-hunt',
			sprintf(
				"wp.data.dispatch('wapuugotchi/wapuugotchi').__initialize(%s)",
				json_encode(
					array(
						'categories' => \get_transient( 'wapuugotchi_categories' ),
						'items'      => \get_transient( 'wapuugotchi_items' ),
						'balance'    => get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ),
						'wapuu'      => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ),
						'message'    => false,
						'intention'  => false,
						'restBase'   => $this->get_rest_api(),
					)
				)
			),
			'after'
		);
	}

	public function load_quest_scripts() {
		$assets = require_once __DIR__ . '/../build/quest-log.asset.php';
		wp_enqueue_style( 'wapuugotchi-quest', plugins_url( 'build/quest-log.css', __DIR__ ), array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-quest', plugins_url( 'build/quest-log.js', __DIR__ ), $assets['dependencies'], $assets['version'], true );

		wp_add_inline_script(
			'wapuugotchi-quest',
			sprintf(
				"wp.data.dispatch('wapuugotchi/wapuugotchi').__initialize(%s)",
				json_encode(
					array(
						'categories' => \get_transient( 'wapuugotchi_categories' ),
						'items'      => \get_transient( 'wapuugotchi_items' ),
						'balance'    => get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ),
						'wapuu'      => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ),
						'message'    => false,
						'intention'  => false,
						'restBase'   => $this->get_rest_api(),
					)
				)
			),
			'after'
		);
	}

	public function load_home_scripts() {
		$assets = require_once __DIR__ . '/../build/index.asset.php';
		wp_enqueue_style( 'wapuugotchi-page', plugins_url( 'build/index.css', __DIR__ ), array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-page', plugins_url( 'build/index.js', __DIR__ ), $assets['dependencies'], $assets['version'], true );

		wp_add_inline_script(
			'wapuugotchi-page',
			sprintf(
				"wp.data.dispatch('wapuugotchi/wapuugotchi').__initialize(%s)",
				json_encode(
					array(
						'categories' => \get_transient( 'wapuugotchi_categories' ),
						'items'      => \get_transient( 'wapuugotchi_items' ),
						'balance'    => get_user_meta( get_current_user_id(), 'wapuugotchi_balance__alpha', true ),
						'wapuu'      => json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ) ),
						'message'    => $this->get_notifications(),
						'intention'  => false,
						'restBase'   => $this->get_rest_api(),
					)
				)
			),
			'after'
		);
	}

	private function get_dom_tags() {
		$config = json_decode( get_user_meta( get_current_user_id(), 'wapuugotchi__alpha', true ), true );
		if ( empty( $config ) ) {
			$config = $this->get_collection();
		}

		if ( ! empty( $config['char'] ) ) {
			$dom_elements = '';
			$collection   = array_merge_recursive(
				$this->get_collection( 'lockedCollection.json' ),
				$this->get_collection( 'unlockedCollection.json' )
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
					$item->meta->price = 0;
				}
				$items_collection[ $collection->slug ][ $item->meta->key ] = $item;
			}
		}

		set_transient( 'wapuugotchi_categories', $category_collection, 60 * 60 * 24 );
		set_transient( 'wapuugotchi_items', $items_collection, 60 * 60 * 24 );
	}

	/**
	 * Gets all items avaiable and the ones for the current user. Sets the price to zero if the user did unlock them already.
	 *
	 * @return array
	 */
	private function get_items_for_current_user() {
		//delete_user_meta(get_current_user_id(), 'wapuugotchi__alpha');
		update_user_meta(
			get_current_user_id(),
			'wapuugotchi_unlocked_items__alpha',
			array(
				'ee777691-d3fa-4506-ae20-d6f7a7266d75',
				'ad19fc13-0728-4ad0-98b4-a362ccae5736',
			)
		);
		$wapuugotchi_items   = get_transient( 'wapuugotchi_items' );
		$unlocked_user_items = get_user_meta( get_current_user_id(), 'wapuugotchi_unlocked_items__alpha', true );

		if ( empty( $unlocked_user_items ) ) {
			return $wapuugotchi_items;
		}

		foreach ( $unlocked_user_items as $key ) {
			foreach ( $wapuugotchi_items as $category => $items ) {
				if ( isset( $items[ $key ] ) ) {
					$items[ $key ]->meta->price = 0;
				}
			}
		}

		return $wapuugotchi_items;
	}

	private function get_notifications() {
		$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true );
		$notifications = NotificationManager::get_active_quests();
		$result_array = array();

		if( !is_array($completed_quests) ) {
			return array();
		}

		foreach ($completed_quests as $completed_quest) {
			if ( !isset( $completed_quest['notified'] ) || $completed_quest['notified'] === true) {
				continue;
			}

			$element = array(
				'id' => $completed_quest['id'],
				'category' => 'quest',
				'message' => $completed_quest['message'],
				'type' => $completed_quest['type']
			);

			$result_array[ $completed_quest['id'] ] = $element;
		}

		return array_merge( $notifications, $result_array);
	}

	/**
	 * Formats the REST API url
	 *
	 * @return string
	 */
	private static function get_rest_api() {
		$api      = get_rest_url( null, Api::REST_BASE );
		$find     = 'wp-json';
		$position = strpos( $api, $find );
		if ( $position === false ) {
			return $api;
		}

		return substr( $api, $position + strlen( $find ) );
	}
}