<?php

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

class Content_Collection {

	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
		//add_filter('admin_init', array($this, 'add_wapuugotchi_filter'));

	}

	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_posts_1', null, 'Create 3 posts', 'You created 3 posts!!', 100, 20, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::first_post_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_posts_2', 'count_posts_1', 'Create 5 posts', 'You created 5 posts!!', 100, 25, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::second_post_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_posts_3', 'count_posts_2', 'Create 7 posts', 'You created 7 posts!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::third_post_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_pages_1', null, 'Create 3 pages', 'You created 3 pages!!', 100, 20, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::first_page_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_pages_2', 'count_pages_1', 'Create 5 pages', 'You created 5 pages!!', 100, 25, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::second_page_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_pages_3', 'count_pages_3', 'Create 7 pages', 'You created 7 pages!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::third_page_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_comment_1', null, 'Get your first comment', 'Nice, you got your first comment!', 100, 20, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::get_comments_completed_1' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_comment_2', 'count_comment_1', 'Get 5 comments', 'Amazing, you got 5 comments!', 100, 25, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::get_comments_completed_2' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_comment_3', 'count_comment_2', 'Get 10 comments', 'Awesome, you got 10 comments!!', 100, 30, 'Wapuugotchi\Wapuugotchi\Content_Collection::always_true', 'Wapuugotchi\Wapuugotchi\Content_Collection::get_comments_completed_3' ),
		);

		return array_merge( $default_quest, $quests );
	}

//Posts
	public static function always_true() {
		return true;
	}

	public static function first_post_completed() {
		return wp_count_posts()->publish >= 3;
	}

	public static function second_post_completed() {
		return wp_count_posts()->publish >= 5;
	}

	public static function third_post_completed() {
		return wp_count_posts()->publish >= 7;
	}

	public static function first_page_completed() {
		return wp_count_posts( 'page' )->publish >= 3;
	}

	public static function second_page_completed() {
		return wp_count_posts( 'page' )->publish >= 5;
	}

	public static function third_page_completed() {
		return wp_count_posts( 'page' )->publish >= 7;
	}

	public static function get_comments_completed_1() {
		return ( wp_count_comments()->approved >= 1 );
	}

	public static function get_comments_completed_2() {
		return ( wp_count_comments()->approved >= 5 );
	}

	public static function get_comments_completed_3() {
		return ( wp_count_comments()->approved >= 10 );
	}
}
