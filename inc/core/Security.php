<?php
/**
 * Handles security headers and related security features for WapuuGotchi plugin.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Security
 *
 * Provides security header management for WapuuGotchi admin pages.
 */
class Security {

	/**
	 * Initialize security features.
	 *
	 * @return void
	 */
	public static function init() {
		\add_action( 'admin_init', array( self::class, 'maybe_send_security_headers' ) );
	}

	/**
	 * Send security headers for WapuuGotchi admin pages.
	 *
	 * @return void
	 */
	public static function maybe_send_security_headers() {
		// Only apply to WapuuGotchi pages.
		$screen = \get_current_screen();
		if ( ! $screen || strpos( $screen->id, 'wapuugotchi' ) === false ) {
			return;
		}

		self::send_security_headers();
	}

	/**
	 * Send HTTP security headers.
	 *
	 * @return void
	 */
	private static function send_security_headers() {
		// Don't send headers if already sent.
		if ( headers_sent() ) {
			return;
		}

		/**
		 * X-Content-Type-Options: Prevent MIME type sniffing
		 * This prevents browsers from interpreting files as a different MIME type.
		 */
		header( 'X-Content-Type-Options: nosniff' );

		/**
		 * X-Frame-Options: Prevent clickjacking
		 * SAMEORIGIN allows framing only from the same origin.
		 */
		header( 'X-Frame-Options: SAMEORIGIN' );

		/**
		 * Referrer-Policy: Control referrer information
		 * strict-origin-when-cross-origin provides a good balance of privacy and functionality.
		 */
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );

		/**
		 * X-XSS-Protection: Enable browser XSS protection
		 * Mode=block tells browser to block page if XSS is detected.
		 * Note: This is legacy but still provides defense-in-depth.
		 */
		header( 'X-XSS-Protection: 1; mode=block' );

		/**
		 * Content-Security-Policy: Control resource loading
		 * This is a basic CSP that allows:
		 * - Scripts and styles from same origin
		 * - Images from same origin and data URIs (for inline SVGs)
		 * - Connections to same origin
		 * - No plugins, frames from other origins
		 *
		 * Admins can customize this using the filter hook.
		 */
		$csp = self::get_content_security_policy();

		/**
		 * Filter the Content Security Policy for WapuuGotchi pages.
		 *
		 * @since 1.0.0
		 *
		 * @param string $csp The Content Security Policy directives.
		 */
		$csp = \apply_filters( 'wapuugotchi_content_security_policy', $csp );

		if ( ! empty( $csp ) ) {
			header( "Content-Security-Policy: $csp" );
		}
	}

	/**
	 * Get the Content Security Policy for WapuuGotchi.
	 *
	 * @return string The CSP directives.
	 */
	private static function get_content_security_policy() {
		$directives = array(
			"default-src 'self'",
			"script-src 'self' 'unsafe-inline' 'unsafe-eval'", // unsafe-inline and unsafe-eval needed for WordPress admin.
			"style-src 'self' 'unsafe-inline'", // unsafe-inline needed for inline styles.
			"img-src 'self' data:",  // data: needed for inline SVGs.
			"font-src 'self' data:",
			"connect-src 'self'",
			"frame-ancestors 'self'",
			"form-action 'self'",
			"base-uri 'self'",
		);

		return implode( '; ', $directives );
	}

	/**
	 * Sanitize and validate a nonce.
	 *
	 * Helper method for consistent nonce validation across the plugin.
	 *
	 * @param string $nonce  The nonce to validate.
	 * @param string $action The nonce action.
	 *
	 * @return bool True if nonce is valid, false otherwise.
	 */
	public static function verify_nonce( $nonce, $action ) {
		if ( empty( $nonce ) || empty( $action ) ) {
			return false;
		}

		return \wp_verify_nonce( $nonce, $action ) !== false;
	}
}
