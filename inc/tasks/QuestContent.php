<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class QuestContent {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_quest_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	/**
	 * Initialization filter for QuestDate
	 *
	 * @param array $quests Array of quest objects.
	 *
	 * @return array|Quest[]
	 */
	public function add_wapuugotchi_filter( $quests ) {
		$default_quest = array(
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_posts_1', null, __( 'Post-it Palooza', 'wapuugotchi' ), __( 'Enter a thrilling quest in the land of WordPress, where you must conjure your creative powers to craft three legendary posts. Overcome the treacherous jungles of writer`s block and conquer the distractions to earn the admiration of the digital realm. Your words will be a beacon of knowledge, humor, and wit, spreading joy and wisdom throughout. Will you rise to the challenge of this epic quest?', 'wapuugotchi' ), __( 'You created 3 posts!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::first_post_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_posts_2', 'count_posts_1', __( 'Create 5 posts', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'You created 5 posts!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::second_post_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_posts_3', 'count_posts_2', __( 'Create 7 posts', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'You created 7 posts!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::third_post_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_pages_1', null, __( 'Create 3 pages', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'You created 3 pages!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::first_page_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_pages_2', 'count_pages_1', __( 'Create 5 pages', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'You created 5 pages!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::second_page_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_pages_3', 'count_pages_3', __( 'Create 7 pages', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'You created 7 pages!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::third_page_completed' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_comment_1', null, __( 'Get 1 comment', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'Cool, we get some attention. &#10024;', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::get_comments_completed_1' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_comment_2', 'count_comment_1', __( 'Get 5 comments', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'We get more and more attention. &#10024;', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::get_comments_completed_2' ),
			new \Wapuugotchi\Wapuugotchi\Quest( 'count_comment_3', 'count_comment_2', __( 'Get 10 comments', 'wapuugotchi' ), __( 'placeholder', 'wapuugotchi' ), __( 'Oh my god!', 'wapuugotchi' ) . PHP_EOL . __( 'We are starting to become famous. &#127775;', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::get_comments_completed_3' ),
		);

		return array_merge( $default_quest, $quests );
	}

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
		return ( wp_count_comments()->approved >= 1 );
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
}
