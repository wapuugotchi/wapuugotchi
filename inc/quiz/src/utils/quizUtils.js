import { getTags } from './textUtils';
/**
 * Wählt ein zufälliges Quiz-Element aus einer Liste aus.
 * @param {Array} list - Die Liste der Quiz-Elemente.
 * @return {Array} Ein zufälliges Element aus der Liste.
 */
export const getQuizElement = ( list ) => {
	const listElement = list[ 0 ];
	const quizElement = {
		question: getTags( listElement.question, 25 ),
		agreement: getTags( listElement.correct_notice, 25 ),
		disagreement: getTags( listElement.incorrect_notice, 25 ),
		answers: [],
		position: 0,
	};
	const { wrongAnswers, correctAnswer } = listElement;
	const answers = wrongAnswers
		.sort( () => Math.random() - 0.5 )
		.slice( 0, 2 );
	answers.push( correctAnswer );
	quizElement.answers = answers.sort( () => Math.random() - 0.5 );
	quizElement.position = quizElement.answers.indexOf(
		listElement.correctAnswer
	);

	return quizElement;
};
