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
			new Quest( 'count_posts_1', null, __( 'Post-it Palooza: The Awakening', 'wapuugotchi' ), __( 'Enter a thrilling quest in the land of WordPress, where you must conjure your creative powers to craft three legendary posts. Overcome the treacherous jungles of writer`s block and conquer the distractions to earn the admiration of the digital realm. Your words will be a beacon of knowledge, humor, and wit, spreading joy and wisdom throughout. Will you rise to the challenge of this epic quest?', 'wapuugotchi' ), __( 'You created 3 posts!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::first_post_completed' ),
			new Quest( 'count_posts_2', 'count_posts_1', __( 'Post-it Palooza: The Content Crusade', 'wapuugotchi' ), __( 'Prepare for an epic journey in the realm of WordPress, where you must unleash your creative prowess to craft five legendary posts. Ward off the sly procrastination pixies, navigate through the maze of writer\'s block, and emerge as the esteemed champion of content creation in the digital domain. The quest awaits!', 'wapuugotchi' ), __( 'You created 5 posts!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::second_post_completed' ),
			new Quest( 'count_posts_3', 'count_posts_2', __( 'Post-it Palooza: The Maginificent Seven', 'wapuugotchi' ), __( 'Prepare yourself for an extraordinary quest in the realm of WordPress. Your task is to craft seven illustrious posts, brimming with wit and wisdom, to captivate the denizens of the web. Embark on a comical adventure as you dodge mischievous distractions and outsmart pesky writer\'s block monsters. Will you rise to the challenge and unleash the magnificence of your writing prowess upon the digital realm?', 'wapuugotchi' ), __( 'You created 7 posts!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::third_post_completed' ),
			new Quest( 'count_pages_1', null, __( 'Page-Master Supreme', 'wapuugotchi' ), __( 'Set out on an epic journey in the realm of WordPress to demonstrate your page-making skills! Craft a captivating homepage, an intriguing About page, and an irresistible contact page to prove your mastery. Will you rise to the challenge and leave the internet realm in awe of your creations?', 'wapuugotchi' ), __( 'You created 3 pages!!', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::first_page_completed' ),
			new Quest( 'count_pages_2', 'count_pages_1', __( 'Page-Master Supreme: The Grand Expedition', 'wapuugotchi' ), __( 'Embark on an epic journey in the WordPress Kingdom to showcase your legendary page-crafting skills! Craft a mesmerizing homepage, an enthralling About page, a captivating Services page, a wondrous Portfolio page, and an irresistible Contact page to leave a lasting mark on the digital realm. Will you rise to the challenge and earn the title of Website Grandmaster?', 'wapuugotchi' ), __( 'You created 5 pages!!', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::second_page_completed' ),
			new Quest( 'count_pages_3', 'count_pages_3', __( 'Page-Master Supreme: The Odyssey', 'wapuugotchi' ), __( 'Prepare to embark on a grand odyssey within the WordPress Kingdom, where a noble quest awaits! Your mission, should you choose to accept it, is to scale the heights of page-crafting greatness by creating not one, not two, but seven magnificent pages that will inspire awe throughout the digital realm.', 'wapuugotchi' ), __( 'You created 7 pages!!', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::third_page_completed' ),
			new Quest( 'count_comment_1', null, __( 'The Comment Conundrum: A WordPress Adventure', 'wapuugotchi' ), __( 'Embark on a whimsical adventure through the labyrinthine world of WordPress, where you must navigate treacherous forums and dodge spam bots to uncover the legendary artifact known as "The One Comment." Will you brave the maze of moderation queues and vanquish the trolls to claim your prize, or will your quest be lost in the sea of digital noise? Only the bravest and most cunning adventurers will emerge victorious and earn the coveted title of "Master Comment Hunter." Good luck, noble quester, for the fate of your blog rests in your quick wit and keen eye for engaging conversation!', 'wapuugotchi' ), __( 'Cool, we get some attention. &#10024;', 'wapuugotchi' ), 'success', 100, 1, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::get_comments_completed_1' ),
			new Quest( 'count_comment_2', 'count_comment_1', __( 'The Comment Conundrum: Fivefold Challenge', 'wapuugotchi' ), __( 'Prepare to embark on an epic odyssey through the digital domain of WordPress, where the fabled "Five Comment Orbs" await discovery. Venturing into the bustling expanse of blog posts and articles, you must navigate the winding paths of engagement and outwit the cunning discourse monsters that guard the precious comments. Gather your allies, hone your wordsmithing skills, and overcome the trials of moderation queues and captchas to emerge triumphant in the realm of comments. Will you rise as the esteemed Champion of Engagement, or be forever lost in the labyrinth of silence? Only the most valiant and savvy adventurers will lay claim to the Five Comment Orbs and earn the esteemed title of "Comment Conqueror"! Do you dare to take on this daunting quest and unlock the power of the comments? Only time and wit will unveil the answer!', 'wapuugotchi' ), __( 'We get more and more attention. &#10024;', 'wapuugotchi' ), 'success', 100, 2, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::get_comments_completed_2' ),
			new Quest( 'count_comment_3', 'count_comment_2', __( 'The Comment Conundrum: Pursuit of the DecaComments', 'wapuugotchi' ), __( 'Behold, intrepid wayfarer of the WordPress realm! Prepare to embark on the monumental Great Comment Crusade, where the legendary "DecaComments" stand as the ultimate testament to your mastery of digital discourse. Venture forth into the expansive blogosphere, where unfathomable depths of wisdom and wit await discovery. Forge alliances with fellow scribes and duel with the elusive spam bots as you navigate the labyrinthine pathways of engagement to unearth the precious DecaComments hidden within the digital fabric. Will you rise as the illustrious Grandmaster of Engagement, revered by peers and denizens alike, or falter in the shadow of silence? Only the most resilient and eloquent wordsmiths will emerge victorious, claiming the prestigious title of "Comment Maestro." Dare you traverse the luminous trail of the DecaComments and etch your name into the annals of WordPress lore? The fate of engagement awaits your bold and cunning spirit!', 'wapuugotchi' ), __( 'Oh my god!', 'wapuugotchi' ) . PHP_EOL . __( 'We are starting to become famous. &#127775;', 'wapuugotchi' ), 'success', 100, 3, 'Wapuugotchi\Wapuugotchi\QuestContent::always_true', 'Wapuugotchi\Wapuugotchi\QuestContent::get_comments_completed_3' ),
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
