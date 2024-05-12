<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quest\Data;

use Wapuugotchi\Quest\Models\Quest;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestContent
 */
class QuestContent {

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
	public static function first_post_completed() {
		return wp_count_posts()->publish >= 3;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function second_post_completed() {
		return wp_count_posts()->publish >= 5;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function third_post_completed() {
		return wp_count_posts()->publish >= 7;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function first_page_completed() {
		return wp_count_posts( 'page' )->publish >= 3;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function second_page_completed() {
		return wp_count_posts( 'page' )->publish >= 5;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function third_page_completed() {
		return wp_count_posts( 'page' )->publish >= 7;
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function get_comments_completed_1() {
		return ( wp_count_comments()->approved >= 2 );
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function get_comments_completed_2() {
		return ( wp_count_comments()->approved >= 5 );
	}

	/**
	 * Check completion requirement.
	 *
	 * @return bool
	 */
	public static function get_comments_completed_3() {
		return ( wp_count_comments()->approved >= 10 );
	}

	/**
	 * Initialization filter for QuestDate
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public static function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new Quest( 'count_posts_1', null, __( 'Create 3 posts', 'wapuugotchi' ), __( 'You created 3 posts!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::first_post_completed' ),
			new Quest( 'count_posts_2', 'count_posts_1', __( 'Create 5 posts', 'wapuugotchi' ), __( 'You created 5 posts!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::second_post_completed' ),
			new Quest( 'count_posts_3', 'count_posts_2', __( 'Create 7 posts', 'wapuugotchi' ), __( 'You created 7 posts!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::third_post_completed' ),
			new Quest( 'count_posts_4', 'count_posts_2', __( 'Create 10 posts', 'wapuugotchi' ), __( 'You created 10 posts!!', 'wapuugotchi' ), 'success', 100, 5, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::third_post_completed' ),
			new Quest( 'count_pages_1', null, __( 'Create 3 pages', 'wapuugotchi' ), __( 'You created 3 pages!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::first_page_completed' ),
			new Quest( 'count_pages_2', 'count_pages_1', __( 'Create 5 pages', 'wapuugotchi' ), __( 'You created 5 pages!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::second_page_completed' ),
			new Quest( 'count_pages_3', 'count_pages_3', __( 'Create 7 pages', 'wapuugotchi' ), __( 'You created 7 pages!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::third_page_completed' ),
			new Quest( 'count_comment_1', null, __( 'Get 2 comment', 'wapuugotchi' ), __( 'Cool, we get some attention. &#10024;', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::get_comments_completed_1' ),
			new Quest( 'count_comment_2', 'count_comment_1', __( 'Get 5 comments', 'wapuugotchi' ), __( 'We get more and more attention. &#10024;', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::get_comments_completed_2' ),
			new Quest( 'count_comment_3', 'count_comment_2', __( 'Get 10 comments', 'wapuugotchi' ), __( 'Oh my god!', 'wapuugotchi' ) . PHP_EOL . __( 'We are starting to become famous. &#127775;', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Quest\Data\QuestContent::always_true', 'Wapuugotchi\Quest\Data\QuestContent::get_comments_completed_3' ),
		);

		return array_merge( $default_quest, $quests );
	}
}
