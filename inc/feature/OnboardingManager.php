<?php
/**
 * The Quest Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestManager
 */
class OnboardingManager {
	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
	}

	/**
	 * Get page specific tour data submitted using the filter.
	 *
	 * @param string $page The page name.
	 *
	 * @return bool|mixed|null The onboarding data.
	 */
	public static function get_page_data( $page = null ) {
		if ( empty( $page ) ) {
			return null;
		}
		$onboarding = self::get_global_data();

		if ( empty( $onboarding ) ) {
			return null;
		}

		foreach ( $onboarding as $key => $value ) {

			if ( $value->page !== $page ) {
				unset( $onboarding[ $key ] );
			}
		}

		return json_decode( wp_json_encode( $onboarding[0] ), true );
	}

	/**
	 * Get global onboarding data.
	 *
	 * @return mixed|null The onboarding data.
	 */
	public static function get_global_data() {
		$onboarding = wp_cache_get( 'wapuugotchi_onboarding' );

		if ( ! empty( $onboarding ) ) {
			return $onboarding;
		}

		$onboarding = apply_filters( 'wapuugotchi_onboarding_filter', array() );

		wp_cache_set( 'wapuugotchi_quests', $onboarding );

		if ( empty( $onboarding ) ) {
			return null;
		}

		return $onboarding[0];
	}

	/**
	 * Get the onboarding order.
	 *
	 * @return array The onboarding order.
	 */
	public static function get_onboarding_order() {
		return array(
			'wapuugotchi_page_wapuugotchi-onboarding' => 'admin.php?page=wapuugotchi-onboarding',
			'dashboard'                               => 'index.php',
			'update-core'                             => 'update-core.php',
			'edit-post'                               => 'edit.php',
			'post'                                    => 'post-new.php',
			'edit-category'                           => 'edit-tags.php?taxonomy=category',
			'edit-post_tag'                           => 'edit-tags.php?taxonomy=post_tag',
			'upload'                                  => 'upload.php',
			'media'                                   => 'media-new.php',
			'edit-page'                               => 'edit.php?post_type=page',
			'page'                                    => 'post-new.php?post_type=page',
			'edit-comments'                           => 'edit-comments.php',
			'themes'                                  => 'themes.php',
			'theme-install'                           => 'theme-install.php?browse=popular',
			'site-editor'                             => 'site-editor.php',
			'plugins'                                 => 'plugins.php',
			'plugin-install'                          => 'plugin-install.php',
			'users'                                   => 'users.php',
			'user'                                    => 'user-new.php',
			'profile'                                 => 'profile.php',
			'tools'                                   => 'tools.php',
			'import'                                  => 'import.php',
			'export'                                  => 'export.php',
			'site-health'                             => 'site-health.php',
			'export-personal-data'                    => 'export-personal-data.php',
			'erase-personal-data'                     => 'erase-personal-data.php',
			'theme-editor'                            => 'theme-editor.php',
			'plugin-editor'                           => 'plugin-editor.php',
			'options-general'                         => 'options-general.php',
			'options-writing'                         => 'options-writing.php',
			'options-reading'                         => 'options-reading.php',
			'options-discussion'                      => 'options-discussion.php',
			'options-media'                           => 'options-media.php',
			'options-permalink'                       => 'options-permalink.php',
			'options-privacy'                         => 'options-privacy.php',
			'toplevel_page_wapuugotchi'               => 'admin.php?page=wapuugotchi',
			'wapuugotchi_page_wapuugotchi-quests'     => 'admin.php?page=wapuugotchi-quests',
		);
	}

	/**
	 * Get the next page by the current page.
	 *
	 * @param string $current_page The current page.
	 *
	 * @return string|null The next page.
	 */
	public static function get_next_page_by_current_page( $current_page ) {
		$onboarding_order = self::get_onboarding_order();
		$next_page        = null;

		$keys        = array_keys( $onboarding_order );
		$first_index = array_search( $current_page, $keys, true );
		if ( false !== $first_index && isset( $keys[ $first_index + 1 ] ) ) {
			$next_page = $onboarding_order[ $keys[ $first_index + 1 ] ];
		}

		return $next_page;
	}
}
