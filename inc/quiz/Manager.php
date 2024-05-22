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
	 * "Constructor" of this Class
	 */
	public function __construct() {

		\add_filter( 'wapuugotchi_quiz__filter', array( QuizWordPress::class, 'add_wp_quiz' ) );

		\add_action( 'admin_enqueue_scripts', array( $this, 'load_scripts' ) );
	}

	/**
	 * Load the scripts for the Quiz page.
	 */
	public function load_scripts() {
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
						'data'   => QuizHandler::get_quiz_array(),
					)
				)
			),
			'after'
		);

		\wp_set_script_translations( 'wapuugotchi-quiz', 'wapuugotchi', WAPUUGOTCHI_PATH . 'languages/' );
	}
}
