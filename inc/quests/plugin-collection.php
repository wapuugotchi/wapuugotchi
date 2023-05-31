<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Plugin_Collection {

	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
		//add_filter('admin_init', array($this, 'add_wapuugotchi_filter'));

	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'use_seo_plugin_1', null, 'Activate a SEO plugin', 'Awesome! &#128261;' . PHP_EOL .'We are using an SEO plugin. This will help us to be found by search engines.', 100, 2, 'Wapuugotchi\Wapuugotchi\Plugin_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Plugin_Collection::seo_installed_completed_1' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'use_caching_plugin_1', null, 'Activate a caching plugin', 'Fantastic! &#128171;' . PHP_EOL . 'We are using a caching plugin. This way we can increase the speed of our website.', 100, 2, 'Wapuugotchi\Wapuugotchi\Plugin_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Plugin_Collection::caching_installed_completed_1' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'use_security_plugin_1', null, 'Activate a security plugin', 'Great!' . PHP_EOL . 'We are using a security plugin. This will help us protect me from villains. &#128170;', 100, 2, 'Wapuugotchi\Wapuugotchi\Plugin_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Plugin_Collection::security_installed_completed_1' ),
		);

		return array_merge( $default_quest, $quests );
	}

//Posts
	public static function always_true() {
		return true;
	}

	public static function seo_installed_completed_1() {
		$list = array(
			'all-in-one-seo-pack',
			'wordpress-seo',
			'semrush-seo-writing-assistant',
			'ahrefs-seo',
			'seo-by-rank-math',
			'wp-seopress'
		);

		return self::is_active_plugin_in_list( $list );
	}

	public static function caching_installed_completed_1() {
		$list = array(
			'wp-asset-clean-up',
			'litespeed-cache',
			'w3-total-cache',
			'wp-optimize',
			'wp-fastest-cache',
			'wp-super-cache'
		);

		return self::is_active_plugin_in_list( $list );
	}

	public static function security_installed_completed_1() {
		$list = array(
			'all-in-one-wp-security-and-firewall',
			'defender-security',
			'better-wp-security',
			'jetpack',
			'really-simple-ssl',
			'wp-simple-firewall',
			'sucuri-scanner',
			'wordfence'
		);

		return self::is_active_plugin_in_list( $list );
	}


	//helper
	private static function is_active_plugin_in_list( $list ) {
		if ( ! is_array( $list ) ) {
			return false;
		}
		$activated_plugin = get_option( 'active_plugins' );
		$plugins          = get_plugins();

		$activated_plugin_slugs = array();
		foreach ( $activated_plugin as $p ) {
			if ( isset( $plugins[ $p ] ) ) {
				$activated_plugin_slugs[] = dirname( $p );
			}
		}

		return ! empty( array_intersect( $list, $activated_plugin_slugs ) );
	}
}
