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
	 * Detail of the answer.
	 *
	 * @var string
	 */
	private $detail = '';

	/**
	 * "Constructor" of this Class
	 *
	 * @param string $id ID of the quiz.
	 * @param string $question Question of the quiz.
	 * @param array  $wrong_answers Wrong answers of the quiz.
	 * @param string $correct_answer Correct answer of the quiz.
	 * @param string $detail Detail of the answer.
	 */
	public function __construct( $id, $question, $wrong_answers, $correct_answer, $detail ) {
		$this->id             = $id;
		$this->question       = $question;
		$this->wrong_answers  = $wrong_answers;
		$this->correct_answer = $correct_answer;
		$this->detail         = $detail;
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
	 * Get the detail of the answer.
	 *
	 * @return string $detail
	 */
	public function get_detail() {
		return $this->detail;
	}

	/**
	 * Set the detail of the answer.
	 *
	 * @param string $detail Detail of the answer.
	 */
	public function set_detail( $detail ) {
		$this->detail = $detail;
	}
}
