import './clouds.scss';
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../store";
import Cloud from "./cloud";


export default function Clouds() {
	const {quiz} = useSelect((select) => {
		return {
			quiz: select(STORE_NAME).getQuiz(),
		};
	});

	const getAnswers = () => {
		let answers = [];
		answers.push(...quiz.wrongAnswers);
		answers.push(quiz.correctAnswer);
		answers = answers.sort(() => Math.random() - 0.5);

		return answers;
	}

	return (
		<div id="wapuugotchi_quiz__clouds">
			{getAnswers()?.map((answer, index) => {
				return <Cloud text={answer}/>;
			})}
		</div>
	);
}
