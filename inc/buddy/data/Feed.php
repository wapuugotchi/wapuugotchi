<?php
/**
 * The Feed Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Buddy\Data;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Feed
 */
class Feed {
	const WAPUUGOTCHI_FEED_URL = 'https://wapuugotchi.github.io/feed/feed.xml';
	const FEED_ITEMS = 'wapuugotchi_feed_items';
	const DISMISSED_ITEMS = 'wapuugotchi_feed_dismissed';
	const CACHE_TTL = 12 * HOUR_IN_SECONDS;
	const DISMISSED_TTL = 30 * DAY_IN_SECONDS;

	/**
	 * Add feed items to the message list.
	 *
	 * @param array $messages Message list.
	 *
	 * @return array
	 */
	public static function add_feed_filter( $messages ) {
		$items = self::get_data();
		if ( ! is_array( $items ) ) {
			return $messages;
		}

		foreach ( $items as $item ) {
			$message_id    = 'buddy-feed_' . $item['id'];
			$is_active     = function () use ( $message_id ) {
				return self::is_active( $message_id );
			};
			$handle_submit = function ( $id ) use ( $message_id ) {
				return self::handle_submit( $id, $message_id );
			};

			$messages[] =
				new \Wapuugotchi\Avatar\Models\Message(
					$message_id,
					$item['description'] . self::render_iframe( $item['iframe'] ),
					'info',
					$is_active,
					$handle_submit
				);
			break;
		}

		return $messages;
	}

	/**
	 * Get cached feed items or fetch them when missing.
	 *
	 * @return array|null
	 */
	public static function get_data() {
		\delete_transient( self::FEED_ITEMS ); // For testing purposes only.
		$items = get_transient( self::FEED_ITEMS );
		if ( false === $items ) {
			$data  = self::fetch_data();
			$items = self::extract_elements_from_xml( $data );

			set_transient( self::FEED_ITEMS, $items, self::CACHE_TTL );

			self::user_meta_cleanup( $items );
		}

		return $items;
	}

	/**
	 * Remove dismissed items that no longer exist in the feed.
	 *
	 * @param array $items Feed items.
	 *
	 * @return void
	 */
	private static function user_meta_cleanup( $items ) {
		if ( ! is_array( $items ) ) {
			return;
		}

		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return;
		}

		$valid_ids = array();
		foreach ( $items as $item ) {
			if ( empty( $item['id'] ) ) {
				continue;
			}
			$valid_ids[] = 'buddy-feed_' . $item['id'];
		}

		if ( empty( $valid_ids ) ) {
			return;
		}

		$meta = get_user_meta( $user_id, self::DISMISSED_ITEMS, true );
		if ( ! is_array( $meta ) ) {
			return;
		}

		$filtered = array_values( array_intersect( $meta, array_unique( $valid_ids ) ) );
		if ( $filtered !== $meta ) {
			update_user_meta( $user_id, self::DISMISSED_ITEMS, $filtered );
		}
	}

	/**
	 * Fetch the feed XML.
	 *
	 * @return string|null
	 */
	private static function fetch_data() {
		$response = wp_remote_get( self::WAPUUGOTCHI_FEED_URL );
		if ( is_wp_error( $response ) ) {
			return;
		}

		return wp_remote_retrieve_body( $response );
	}

	/**
	 * Extract feed items from XML.
	 *
	 * @param string $data Feed XML.
	 *
	 * @return array|null
	 */
	private static function extract_elements_from_xml( $data ) {
		$xml = simplexml_load_string( $data, 'SimpleXMLElement', LIBXML_NOCDATA );

		// Check if XML is valid.
		if ( false === $xml || ! isset( $xml->channel ) ) {
			return;
		}

		// Check if there are items.
		if ( ! isset( $xml->channel->item ) ) {
			return;
		}

		$items = array();
		foreach ( $xml->channel->item as $item ) {
			$items[] = array(
				'id'          => (string) $item->id,
				'title'       => (string) $item->title,
				'description' => (string) $item->description,
				'iframe'      => (string) $item->iframe,
				'link'        => (string) $item->link,
			);
		}

		return $items;
	}

	/**
	 * Build the iframe HTML for a feed item.
	 *
	 * @param string $src Iframe URL.
	 *
	 * @return string
	 */
	private static function render_iframe( $src ) {
		$src = trim( (string) $src );
		if ( '' === $src ) {
			return '';
		}

		$placeholder_url = plugin_dir_url( dirname( __FILE__ ) ) . 'assets/two_click.jpg';

		return sprintf(
			'<div class="wapuugotchi-iframe-placeholder" data-iframe-src="%s">
				<img src="%s" alt="Click to load external content" />
			</div>',
			esc_url( $src ),
			esc_url( $placeholder_url )
		);
	}

	/**
	 * Check if the message is active.
	 *
	 * @param string $message_id Message id.
	 *
	 * @return bool
	 */
	public static function is_active( $message_id ) {
		$user_id = get_current_user_id();
		delete_user_meta( $user_id, self::DISMISSED_ITEMS );
		if ( ! $user_id ) {
			return true;
		}

		$state = true;
		$meta  = get_user_meta( $user_id, self::DISMISSED_ITEMS, true );

		if ( ! is_array( $meta ) ) {
			$meta = array();
		}
		if ( in_array( $message_id, $meta, true ) ) {
			$state = false;
		}

		return $state;
	}

	/**
	 * Handle the submission of the message.
	 *
	 * @param string $id Message id.
	 * @param string $message_id Feed message id.
	 *
	 * @return bool
	 */
	public static function handle_submit( $id, $message_id ) {
		$user_id = get_current_user_id();
		if ( ! $user_id ) {
			return false;
		}

		$meta = get_user_meta( $user_id, self::DISMISSED_ITEMS, true );
		if ( ! is_array( $meta ) ) {
			$meta = array();
		}
		if ( ! in_array( $message_id, $meta, true ) ) {
			$meta[] = $message_id;
		}

		return update_user_meta( $user_id, self::DISMISSED_ITEMS, $meta );
	}
}
