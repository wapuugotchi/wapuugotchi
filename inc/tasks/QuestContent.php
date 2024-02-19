<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Wapuugotchi\Tasks;

use Wapuugotchi\Wapuugotchi\Models\Quest;

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
			// Quest row related to posts.
			new Quest( 'count_posts_1', null, __( 'Post-it Palooza: The Awakening', 'wapuugotchi' ), __( 'Embark on an exciting journey into the realm of WordPress, unleash your creativity and write three blog posts. Don\'t let writer\'s block stop you and overcome distractions to take off with your blog. Are you ready to take on the challenge?', 'wapuugotchi' ), __( 'You created 3 posts!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::first_post_completed' ),
			new Quest( 'count_posts_2', 'count_posts_1', __( 'Post-it Palooza: The Content Crusade', 'wapuugotchi' ), __( 'You\'ve already taken the first step and your blog has awakened with your first few posts. But now you need to continue your journey to keep your blog alive. Write two more posts so that there are five posts on your site. Are you ready to continue your journey?', 'wapuugotchi' ), __( 'You created 5 posts!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::second_post_completed' ),
			new Quest( 'count_posts_3', 'count_posts_2', __( 'Post-it Palooza: The Maginificent Seven', 'wapuugotchi' ), __( 'The challenge is almost done, we\'ve filled your blog with its first five posts, but the magnificent seven are expecting more posts to leave your page in peace. Write two more posts to appease the magnificent seven. Are you ready to defend your blog?', 'wapuugotchi' ), __( 'You created 7 posts!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::third_post_completed' ),
			// Quest row related to pages.
			new Quest( 'count_pages_1', null, __( 'Page-Master Supreme', 'wapuugotchi' ), __( 'Embark on an exciting journey in WordPress and put your page building skills to the test. Design a captivating homepage, a fascinating info page and an informative contact page to show off your skills. Will you be up to the challenge?', 'wapuugotchi' ), __( 'You created 3 pages!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::first_page_completed' ),
			new Quest( 'count_pages_2', 'count_pages_1', __( 'Page-Master Supreme: The Grand Expedition', 'wapuugotchi' ), __( 'You\'ve already proven your ability to build pages, but your skill is still needed. Two more pages are needed to breathe more life into your WordPress. For example, inform your visitors about data protection or create an imprint. Are you ready to put your skills to the test again?', 'wapuugotchi' ), __( 'You created 5 pages!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::second_page_completed' ),
			new Quest( 'count_pages_3', 'count_pages_3', __( 'Page-Master Supreme: The Maginificent Seven', 'wapuugotchi' ), __( 'Oh no, the magnificent seven are blocking your path to completing this task. To appease them you must create two more pages so that you have seven pages for them to let you by. Since you\'ve already proven your creativity, you\'ll probably come up with your own ideas for pages this time. Are you ready to complete your task?', 'wapuugotchi' ), __( 'You created 7 pages!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::third_page_completed' ),
			// Quest row related to comments.
			new Quest( 'count_comment_1', null, __( 'The Comment Conundrum: A WordPress Adventure', 'wapuugotchi' ), __( 'Embark on a whimsical adventure through the labyrinthine world of WordPress, where you must navigate treacherous forums and dodge spam bots to uncover the legendary artifact known as "The One Comment." Will you brave the maze of moderation queues and vanquish the trolls to claim your prize, or will your quest be lost in the sea of digital noise? Only the bravest and most cunning adventurers will emerge victorious and earn the coveted title of "Master Comment Hunter." Good luck, noble quester, for the fate of your blog rests in your quick wit and keen eye for engaging conversation!', 'wapuugotchi' ), __( 'Cool, we get some attention. &#10024;', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::get_comments_completed_1' ),
			new Quest( 'count_comment_2', 'count_comment_1', __( 'The Comment Conundrum: Fivefold Challenge', 'wapuugotchi' ), __( 'Prepare to embark on an epic odyssey through the digital domain of WordPress, where the fabled "Five Comment Orbs" await discovery. Venturing into the bustling expanse of blog posts and articles, you must navigate the winding paths of engagement and outwit the cunning discourse monsters that guard the precious comments. Gather your allies, hone your wordsmithing skills, and overcome the trials of moderation queues and captchas to emerge triumphant in the realm of comments. Will you rise as the esteemed Champion of Engagement, or be forever lost in the labyrinth of silence? Only the most valiant and savvy adventurers will lay claim to the Five Comment Orbs and earn the esteemed title of "Comment Conqueror"! Do you dare to take on this daunting quest and unlock the power of the comments? Only time and wit will unveil the answer!', 'wapuugotchi' ), __( 'We get more and more attention. &#10024;', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::get_comments_completed_2' ),
			new Quest( 'count_comment_3', 'count_comment_2', __( 'The Comment Conundrum: Pursuit of the DecaComments', 'wapuugotchi' ), __( 'Behold, intrepid wayfarer of the WordPress realm! Prepare to embark on the monumental Great Comment Crusade, where the legendary "DecaComments" stand as the ultimate testament to your mastery of digital discourse. Venture forth into the expansive blogosphere, where unfathomable depths of wisdom and wit await discovery. Forge alliances with fellow scribes and duel with the elusive spam bots as you navigate the labyrinthine pathways of engagement to unearth the precious DecaComments hidden within the digital fabric. Will you rise as the illustrious Grandmaster of Engagement, revered by peers and denizens alike, or falter in the shadow of silence? Only the most resilient and eloquent wordsmiths will emerge victorious, claiming the prestigious title of "Comment Maestro." Dare you traverse the luminous trail of the DecaComments and etch your name into the annals of WordPress lore? The fate of engagement awaits your bold and cunning spirit!', 'wapuugotchi' ), __( 'Oh my god!', 'wapuugotchi' ) . PHP_EOL . __( 'We are starting to become famous. &#127775;', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\Tasks\QuestContent::get_comments_completed_3' ),
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
