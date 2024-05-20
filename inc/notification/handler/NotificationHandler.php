<?php
/**
 * The AnimationHandler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Notification\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

class NotificationHandler {
	public static function init() {
		add_action( 'current_screen', array( __CLASS__, 'render_feed' ) );
	}
	public static function render_feed( $screen ) {
		try {
			$rss = @simplexml_load_file( 'https://wordpress.org/news/category/releases/feed/' );
			if ( ! $rss || \get_class( $rss ) !== 'SimpleXMLElement' ) {
				throw new \Exception( 'RSS Feed could not be loaded.' );
			}

			$channel_title = (string) $rss->channel->title;
			$item          = $rss->channel->item[0];
			$item_title    = (string) $item->title;
			$item_link     = (string) $item->link;
			$description   = (string) $item->description;

			if (($screen->id === 'wapuugotchi_page_wapuugotchi_notification')) {
				echo '<div class="wrap">';
				echo '<h1>' . esc_html( $channel_title ) . '</h1>';
				echo '<h2>' . esc_html( $item_title ) . '</h2>';
				echo '<p>' . esc_html( $description ) . '</p>';
				echo '<a href="' . esc_url( $item_link ) . '" target="_blank">' . esc_html( $item_link ) . '</a>';
				echo '</div>';
				die();
			}
		}
		catch ( \Exception $e ) {
			/*************** DumpDebugDie ***************/
			echo '<pre>';
			wp_die( var_dump( $e ) );
			echo '</pre>';
			/*************** DumpDebugDie ***************/
		}
	}
}
