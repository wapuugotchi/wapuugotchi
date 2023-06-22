<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

class Avatar {

	public function __construct() {
		add_action( 'admin_enqueue_scripts', array( $this, 'init' ) );
	}

	public function init( $hook_suffix ) {
		if ( $hook_suffix === 'index.php' ) {
			$this->load_scripts();
		}
	}

	public function load_scripts() {
		$assets = require_once WAPUUGOTCHI_PATH . 'build/index.asset.php';
		wp_enqueue_style( 'wapuugotchi-avatar', WAPUUGOTCHI_URL . 'build/index.css', array(), $assets['version'] );
		wp_enqueue_script( 'wapuugotchi-avatar', WAPUUGOTCHI_URL . 'build/index.js', $assets['dependencies'], $assets['version'], true );
		wp_add_inline_script(
			'wapuugotchi-avatar',
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
						'restBase'   => Manager::get_rest_api(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-avatar', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	private function get_notifications() {
		$completed_quests = get_user_meta( get_current_user_id(), 'wapuugotchi_completed_quests__alpha', true );
		$result_array     = array();
		$notifications    = apply_filters( 'wapuugotchi_notifications', array() );

		if ( ! is_array( $completed_quests ) ) {
			return array();
		}

		foreach ( $notifications as $notification ) {
			if ( $notification instanceof Notification === false ) {
				continue;
			}

			$element                                = array(
				'category' => 'note',
				'id'       => $notification->getId(),
				'message'  => $notification->getMessage(),
				'type'     => $notification->getType()
			);
			$result_array[ $notification->getId() ] = $element;
		}

		foreach ( $completed_quests as $completed_quest ) {
			if ( ! isset( $completed_quest['notified'] ) || $completed_quest['notified'] === true ) {
				continue;
			}

			$element = array(
				'category' => 'quest',
				'id'       => $completed_quest['id'],
				'message'  => $completed_quest['message'],
				'type'     => $completed_quest['type']
			);

			$result_array[ $completed_quest['id'] ] = $element;
		}

		return $result_array;
	}

}
