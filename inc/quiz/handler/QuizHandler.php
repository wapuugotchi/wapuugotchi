<?php
/**
 * The Avatar Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Quiz\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Manager
 */
class QuizHandler {

	/**
	 * Apply the filter to get the quiz data.
	 * If the filter is not set, an empty array will be returned.
	 *
	 * @return array
	 */
	public static function get_quiz() {
		$quiz = \apply_filters( 'wapuugotchi_quiz__filter', array() );

		if ( false === $quiz ) {
			$quiz = array();
		}

		return self::validate_quiz( $quiz );
	}

	/**
	 * Validate the quiz data.
	 *
	 * @param array $quiz The quiz data.
	 *
	 * @return array The validated quiz data.
	 */
	private static function validate_quiz( $quiz ) {
		foreach ( $quiz as $index => $item ) {
			// item muss von Typ Quiz sein.
			if ( ! is_a( $item, 'Wapuugotchi\Quiz\Models\Quiz' ) ) {
				unset( $quiz[ $index ] );
				continue;
			}
		}

		return $quiz;
	}

	/**
	 * Get the quiz data as array.
	 *
	 * @return array
	 */
	public static function get_quiz_array() {
		$quiz       = self::get_quiz();
		$quiz_array = array();

		if ( empty( $quiz ) ) {
			return array();
		}

		foreach ( $quiz as $item ) {
			$quiz_array[] = array(
				'id'               => $item->get_id(),
				'question'         => $item->get_question(),
				'wrongAnswers'     => $item->get_wrong_answers(),
				'correctAnswer'    => $item->get_correct_answer(),
				'correct_notice'   => $item->get_correct_notice(),
				'incorrect_notice' => $item->get_incorrect_notice(),
			);
		}

		return $quiz_array;
	}

	/**
	 *
	 * Get shuffled the quiz data as array.
	 *
	 * @return array
	 */
	public static function get_shuffled_quiz_array() {
		$quiz_array = self::get_quiz_array();
		shuffle( $quiz_array );

		return $quiz_array;
	}
}
