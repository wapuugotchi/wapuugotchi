<?php
/**
 * The Manager Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quiz;

use Wapuugotchi\Quiz\Data\QuizWordPress;
use Wapuugotchi\Quiz\Handler\AvatarHandler;
use Wapuugotchi\Quiz\Handler\QuizHandler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 */
class Manager {
	/**
	 * The Game ID
	 */
	const GAME_ID = 'game__2aae341c-cba7-4369-b353-208a0f74d01a';

	/**
	 * "Constructor" of this Class
	 */
	public function __construct() {
		\add_action( 'load-toplevel_page_wapuugotchi', array( $this, 'init' ) );
	}

	/**
	 * Initialization Log
	 */
	public function init() {
		\add_filter( 'wapuugotchi_register_action__filter', array( $this, 'register_game' ) );
		\add_filter( 'wapuugotchi_quiz__filter', array( QuizWordPress::class, 'add_wp_quiz' ) );
		\add_action( 'wapuugotchi_mission__enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Load the scripts for the Quiz page.
	 *
	 * @param string $action The action to load the scripts for.
	 */
	public function load_scripts( $action ) {
		if ( self::GAME_ID !== $action ) {
			return;
		}

		$assets = include_once WAPUUGOTCHI_PATH . 'build/quiz.asset.php';
		\wp_enqueue_style( 'wapuugotchi-quiz', WAPUUGOTCHI_URL . 'build/quiz.css', array(), $assets['version'] );
		\wp_enqueue_script( 'wapuugotchi-quiz', WAPUUGOTCHI_URL . 'build/quiz.js', $assets['dependencies'], $assets['version'], true );

		\wp_add_inline_script(
			'wapuugotchi-quiz',
			\sprintf(
				"wp.data.dispatch('wapuugotchi/quiz').__initialize(%s)",
				\wp_json_encode(
					array(
						'avatar' => AvatarHandler::get_avatar(),
						'data'   => QuizHandler::get_shuffled_quiz_array(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-quiz', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}

	/**
	 * Register the Game
	 *
	 * @param array $games The games array.
	 *
	 * @return array
	 */
	public function register_game( $games ) {
		$games[] = array(
			'id'          => self::GAME_ID,
			'name'        => __( 'WordPress Quiz', 'wapuugotchi' ),
			'description' => __( 'Test your knowledge about WordPress.', 'wapuugotchi' ),
		);

		return $games;
	}
}
