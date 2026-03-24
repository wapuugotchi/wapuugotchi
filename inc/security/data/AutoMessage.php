<?php
/**
 * The AutoMessage Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Security\Data;

use Wapuugotchi\Avatar\Models\Message;
use Wapuugotchi\Security\Handler\MessageHandler;
use Wapuugotchi\Security\Handler\PluginHandler;
use Wapuugotchi\Security\Meta;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Builds security bubble messages.
 */
class AutoMessage {
	/**
	 * Add security messages to the Wapuu bubble.
	 *
	 * @param array $messages Existing messages.
	 *
	 * @return array
	 */
	public static function add_security_messages_filter( $messages ) {
		if ( ! \current_user_can( 'update_plugins' ) ) {
			return $messages;
		}

		$user_id = \get_current_user_id();
		if ( ! $user_id ) {
			return $messages;
		}

		$result = \get_user_meta( $user_id, Meta::RESULT_META_KEY, true );
		if ( ! \is_array( $result ) || empty( $result['body'] ) || ! \is_array( $result['body'] ) ) {
			return $messages;
		}

		$active_slugs        = PluginHandler::get_active_plugin_slugs();
		$problematic_plugins = \array_values(
			\array_filter(
				$result['body'],
				function ( $plugin_result ) use ( $active_slugs ) {
					return ! empty( $plugin_result['checkedVersionHasKnownVulnerabilities'] )
						&& \in_array( $plugin_result['pluginSlug'] ?? '', $active_slugs, true );
				}
			)
		);

		if ( empty( $problematic_plugins ) ) {
			return $messages;
		}

		foreach ( $problematic_plugins as $plugin_result ) {
			$slug                   = isset( $plugin_result['pluginSlug'] ) ? (string) $plugin_result['pluginSlug'] : '';
			$latest_available       = isset( $plugin_result['latestAvailableVersion'] ) ? (string) $plugin_result['latestAvailableVersion'] : '';
			$severity               = isset( $plugin_result['checkedVersionSeverity'] ) ? (string) $plugin_result['checkedVersionSeverity'] : 'unknown';
			$latest_version_is_safe = isset( $plugin_result['latestAvailableVersionHasKnownVulnerabilities'] ) && false === $plugin_result['latestAvailableVersionHasKnownVulnerabilities'];

			if ( '' === $slug ) {
				continue;
			}

			$message_id = 'security-' . $slug;

			$messages[] = new Message(
				$message_id,
				self::get_vulnerability_message( $slug, $latest_version_is_safe, $latest_available ),
				MessageHandler::get_message_type_by_severity( $severity ),
				function () use ( $message_id ) {
					return MessageHandler::is_active( $message_id );
				},
				function () use ( $message_id ) {
					return MessageHandler::handle_submit( $message_id );
				}
			);
		}

		return $messages;
	}

	/**
	 * Return a randomized vulnerability message.
	 *
	 * @param string $slug                   Plugin slug.
	 * @param bool   $latest_version_is_safe Whether the latest available version has no known vulnerabilities.
	 * @param string $latest_available       Latest available version string from the API.
	 *
	 * @return string
	 */
	private static function get_vulnerability_message( $slug, $latest_version_is_safe, $latest_available ) {
		$plugin_name = \esc_html( $slug );
		$intro       = self::pick_variant(
			array(
				// translators: %s: plugin name.
				\sprintf( __( 'Hey, I spotted something about <strong>%s</strong> — the version you\'re running has some known security issues.', 'wapuugotchi' ), $plugin_name ) . '<br>',
				// translators: %s: plugin name.
				\sprintf( __( 'I was doing my usual snooping and <strong>%s</strong> caught my eye. Your current version has a few known vulnerabilities floating around.', 'wapuugotchi' ), $plugin_name ) . '<br>',
				// translators: %s: plugin name.
				\sprintf( __( '<strong>%s</strong> pinged my radar — looks like the version you have is on the known vulnerabilities list.', 'wapuugotchi' ), $plugin_name ) . '<br>',
				// translators: %s: plugin name.
				\sprintf( __( 'Just noticed something about <strong>%s</strong>. The version you\'re on has some known security issues attached to it.', 'wapuugotchi' ), $plugin_name ) . '<br>',
				// translators: %s: plugin name.
				\sprintf( __( 'Something came up about <strong>%s</strong> — there are some known security things tied to your installed version.', 'wapuugotchi' ), $plugin_name ) . '<br>',
			)
		);

		if ( $latest_version_is_safe && '' !== $latest_available ) {
			$outros = self::get_fix_outros( \esc_html( $latest_available ) );
		} elseif ( '' !== $latest_available ) {
			$outros = self::get_no_fix_outros( \esc_html( $latest_available ) );
		} else {
			$outros = self::get_unknown_fix_outros();
		}

		return $intro . ' ' . self::pick_variant( $outros );
	}

	/**
	 * Return possible endings when a safe update is available.
	 *
	 * @param string $version The safe version to update to.
	 *
	 * @return array
	 */
	private static function get_fix_outros( $version ) {
		return array(
			// translators: %s: plugin version number.
			\sprintf( __( 'Version <strong>%s</strong> is out there and looks all clear — go update that one!', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( 'The good news: <strong>%s</strong> doesn\'t have that problem. You should update to that one.', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( 'Version <strong>%s</strong> is clean — seriously, go grab that update.', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( 'The latest, <strong>%s</strong>, is in the clear. Update to it when you get a chance!', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( '<strong>%s</strong> doesn\'t have this issue. Worth updating to that version soon.', 'wapuugotchi' ), $version ),
		);
	}

	/**
	 * Return possible endings when even the latest available version is affected.
	 *
	 * @param string $version The latest available version (still vulnerable).
	 *
	 * @return array
	 */
	private static function get_no_fix_outros( $version ) {
		return array(
			// translators: %s: plugin version number.
			\sprintf( __( 'Even <strong>%s</strong>, the newest one out there, seems to be in the same boat.', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( 'The latest version <strong>%s</strong> doesn\'t look much better, honestly.', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( 'From what I can tell, <strong>%s</strong> is the newest around — and it\'s still on the list.', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( 'Doesn\'t look like <strong>%s</strong> got away clean either, if I\'m honest.', 'wapuugotchi' ), $version ),
			// translators: %s: plugin version number.
			\sprintf( __( 'I also peeked at <strong>%s</strong> — still flagged, unfortunately.', 'wapuugotchi' ), $version ),
		);
	}

	/**
	 * Return possible endings when no version information is available.
	 *
	 * @return array
	 */
	private static function get_unknown_fix_outros() {
		return array(
			__( 'That\'s about as much as I know for now.', 'wapuugotchi' ),
			__( 'I don\'t really have more details on where things stand right now.', 'wapuugotchi' ),
			__( 'Not sure what the situation looks like beyond that.', 'wapuugotchi' ),
		);
	}

	/**
	 * Pick a random message variant.
	 *
	 * @param array $variants Available variants.
	 *
	 * @return string
	 */
	private static function pick_variant( $variants ) {
		if ( empty( $variants ) ) {
			return '';
		}

		return $variants[ \array_rand( $variants ) ];
	}
}
