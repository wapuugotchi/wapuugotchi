<?php
/**
 * The Quiz Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quiz\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Quiz
 */
class Quiz {

	/**
	 * ID of the quiz.
	 *
	 * @var string
	 */
	private $id = '';

	/**
	 * Question of the quiz.
	 *
	 * @var string
	 */
	private $question = '';

	/**
	 * Wrong answers of the quiz.
	 *
	 * @var array
	 */
	private $wrong_answers = array();

	/**
	 * Correct answer of the quiz.
	 *
	 * @var string
	 */
	private $correct_answer = '';

	/**
	 * Notice of the right answer.
	 *
	 * @var string
	 */
	private $correct_notice = '';

	/**
	 * Notice of the wrong answer.
	 *
	 * @var string
	 */
	private $incorrect_notice = '';

	/**
	 * "Constructor" of this Class
	 *
	 * @param string $id ID of the quiz.
	 * @param string $question Question of the quiz.
	 * @param array  $wrong_answers Wrong answers of the quiz.
	 * @param string $correct_answer Correct answer of the quiz.
	 * @param string $correct_notice Notice of the answer.
	 * @param string $incorrect_notice Notice of the wrong answer.
	 */
	public function __construct( $id, $question, $wrong_answers, $correct_answer, $correct_notice, $incorrect_notice ) {
		$this->id               = $id;
		$this->question         = $question;
		$this->wrong_answers    = $wrong_answers;
		$this->correct_answer   = $correct_answer;
		$this->correct_notice   = $correct_notice;
		$this->incorrect_notice = $incorrect_notice;
	}

	/**
	 * Get the ID of the quiz.
	 *
	 * @return string
	 */
	public function get_id() {
		return $this->id;
	}

	/**
	 * Set the ID of the quiz.
	 *
	 * @param string $id ID of the quiz.
	 */
	public function set_id( $id ) {
		$this->id = $id;
	}

	/**
	 * Get the question of the quiz.
	 *
	 * @return string $question
	 */
	public function get_question() {
		return $this->question;
	}

	/**
	 * Set the question of the quiz.
	 *
	 * @param string $question Question of the quiz.
	 */
	public function set_question( $question ) {
		$this->question = $question;
	}

	/**
	 * Get the wrong answers of the quiz.
	 *
	 * @return array $wrong_answers
	 */
	public function get_wrong_answers(): array {
		return $this->wrong_answers;
	}

	/**
	 * Set the wrong answers of the quiz.
	 *
	 * @param array $wrong_answers Wrong answers of the quiz.
	 */
	public function set_wrong_answers( array $wrong_answers ) {
		$this->wrong_answers = $wrong_answers;
	}

	/**
	 * Get the correct answer of the quiz.
	 *
	 * @return string $correct_answer
	 */
	public function get_correct_answer() {
		return $this->correct_answer;
	}

	/**
	 * Set the correct answer of the quiz.
	 *
	 * @param string $correct_answer Correct answer of the quiz.
	 */
	public function set_correct_answer( $correct_answer ) {
		$this->correct_answer = $correct_answer;
	}

	/**
	 * Get the notice of the correct answer.
	 *
	 * @return string $correct_notice
	 */
	public function get_correct_notice() {
		return $this->correct_notice;
	}

	/**
	 * Set the notice of the correct answer.
	 *
	 * @param string $correct_notice Notice of the correct answer.
	 */
	public function set_correct_notice( $correct_notice ) {
		$this->correct_notice = $correct_notice;
	}

	/**
	 * Get the notice of the incorrect answer.
	 *
	 * @return string $correct_notice
	 */
	public function get_incorrect_notice() {
		return $this->incorrect_notice;
	}

	/**
	 * Set the notice of the incorrect answer.
	 *
	 * @param string $incorrect_notice Notice of the incorrect answer.
	 */
	public function set_incorrect_notice( $incorrect_notice ) {
		$this->incorrect_notice = $incorrect_notice;
	}
}
