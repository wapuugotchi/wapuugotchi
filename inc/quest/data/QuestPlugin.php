<?php
/**
 * The QuestPlugin Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Data;

use Wapuugotchi\Quest\Models\Quest;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestPlugin
 */
class QuestPlugin {

	/**
	 * Get true.
	 *
	 * @return true
	 */
	public static function always_true() {
		return true;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function seo_installed_completed_1() {
		$list = array(
			'all-in-one-seo-pack',
			'wordpress-seo',
			'semrush-seo-writing-assistant',
			'ahrefs-seo',
			'seo-by-rank-math',
			'wp-seopress',
		);

		return self::is_active_plugin_in_list( $list );
	}

	/**
	 * Check if one of the given plugins is active.
	 *
	 * @param array $recommended_plugins List of recommended plugins.
	 *
	 * @return bool
	 */
	private static function is_active_plugin_in_list( $recommended_plugins ) {
		if ( ! is_array( $recommended_plugins ) ) {
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

		return ! empty( array_intersect( $recommended_plugins, $activated_plugin_slugs ) );
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function caching_installed_completed_1() {
		$list = array(
			'wp-asset-clean-up',
			'litespeed-cache',
			'w3-total-cache',
			'wp-optimize',
			'wp-fastest-cache',
			'wp-super-cache',
		);

		return self::is_active_plugin_in_list( $list );
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function security_installed_completed_1() {
		$list = array(
			'all-in-one-wp-security-and-firewall',
			'defender-security',
			'better-wp-security',
			'jetpack',
			'really-simple-ssl',
			'wp-simple-firewall',
			'sucuri-scanner',
			'wordfence',
		);

		return self::is_active_plugin_in_list( $list );
	}

	/**
	 * Initialization filter for QuestPlugin
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public static function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new Quest( 'use_seo_plugin_1', null, __( 'Activate a SEO plugin', 'wapuugotchi' ), __( 'Awesome! &#128261;', 'wapuugotchi' ) . PHP_EOL . __( 'You\'ve installed a SEO plugin. Let\'s add some keywords so that search engines can find us better.', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Quest\Data\QuestPlugin::always_true', 'Wapuugotchi\Quest\Data\QuestPlugin::seo_installed_completed_1' ),
			new Quest( 'use_caching_plugin_1', null, __( 'Activate a caching plugin', 'wapuugotchi' ), __( 'Fantastic! &#128171;', 'wapuugotchi' ) . PHP_EOL . __( 'You\'ve installed a caching plugin. This way we can increase the speed of our website.', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Quest\Data\QuestPlugin::always_true', 'Wapuugotchi\Quest\Data\QuestPlugin::caching_installed_completed_1' ),
			new Quest( 'use_security_plugin_1', null, __( 'Activate a security plugin', 'wapuugotchi' ), __( 'Great!', 'wapuugotchi' ) . PHP_EOL . __( 'You\'ve installed a security plugin! This will help protecting me from villains. &#128170;', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Quest\Data\QuestPlugin::always_true', 'Wapuugotchi\Quest\Data\QuestPlugin::security_installed_completed_1' ),
		);

		return array_merge( $default_quest, $quests );
	}
}
