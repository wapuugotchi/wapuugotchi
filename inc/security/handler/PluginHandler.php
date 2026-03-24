<?php
/**
 * The Plugin Handler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Handles installed plugin lookups and payload generation.
 */
class PluginHandler {
	/**
	 * Build the payload expected by the vulnerability batch endpoint.
	 *
	 * @return array
	 */
	public static function get_plugins_payload() {
		if ( ! \function_exists( 'get_plugins' ) ) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		$installed_plugins = \get_plugins();
		$active_plugins    = \get_option( 'active_plugins', array() );
		$payload           = array();

		foreach ( $active_plugins as $plugin_file ) {
			if ( ! isset( $installed_plugins[ $plugin_file ] ) ) {
				continue;
			}

			$plugin_data = $installed_plugins[ $plugin_file ];
			$slug        = self::slug_from_file( $plugin_file );
			$version     = isset( $plugin_data['Version'] ) ? (string) $plugin_data['Version'] : '';

			if ( '' === $slug || '' === $version ) {
				continue;
			}

			$payload[] = array(
				'slug'    => $slug,
				'version' => $version,
			);
		}

		return array_values( $payload );
	}

	/**
	 * Get the slugs of all currently active plugins.
	 *
	 * @return array
	 */
	public static function get_active_plugin_slugs() {
		$active_plugins = \get_option( 'active_plugins', array() );
		$slugs          = array();

		foreach ( $active_plugins as $plugin_file ) {
			$slugs[] = self::slug_from_file( $plugin_file );
		}

		return \array_filter( $slugs );
	}

	/**
	 * Derive a plugin slug from its main file path.
	 *
	 * @param string $plugin_file Plugin file path relative to plugins dir.
	 *
	 * @return string
	 */
	private static function slug_from_file( $plugin_file ) {
		$slug = \dirname( $plugin_file );
		if ( '.' === $slug ) {
			$slug = \basename( $plugin_file, '.php' );
		}

		return $slug;
	}
}
