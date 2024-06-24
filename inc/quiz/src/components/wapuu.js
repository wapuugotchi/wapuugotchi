import { useSelect } from '@wordpress/data';
import { useEffect } from '@wordpress/element';
import { STORE_NAME } from '../store';

export default function Wapuu() {
	const { avatar, quiz } = useSelect( ( select ) => {
		return {
			avatar: select( STORE_NAME ).getAvatar(),
			quiz: select( STORE_NAME ).getQuiz(),
		};
	} );

	useEffect(() => {
		prepareAvatar(avatar);
	}, [avatar, quiz]);

	function getAnswers(quiz) {
		let answers = [];
		answers.push(...quiz.wrongAnswers);
		answers.push(quiz.correctAnswer);
		answers = answers.sort(() => Math.random() - 0.5);

		return answers;
	}

	function getTags( sentence, length) {
		let tags = [];
		let tag = '';
		let words = sentence.split(' ');
		words.forEach((word) => {
			if (tag.length + word.length > length) {
				tags.push(tag);
				tag = word;
			} else {
				tag += ' ' + word;
			}
		});
		tags.push(tag);
		return tags;
	}

	function prepareAvatar( svg ) {
		const avatar = parseSvg( svg );
		const textBoxTags = getTags( quiz.question, 25 );

		let x = parseInt(avatar.querySelector('#TextBox--group')?.querySelector('text')?.getAttribute('x')) || 0;
		let y = parseInt(avatar.querySelector('#TextBox--group')?.querySelector('text')?.getAttribute('y')) || 0;
		textBoxTags?.map((tag, index) => {
			const tspan = document.createElement( 'TSPAN' );
			tspan.textContent = tag;
			tspan.setAttribute('x', x);
			tspan.setAttribute('y', y);
			avatar.querySelector('#TextBox--group')?.querySelector('text')?.appendChild(tspan);
			y += 20;
		});

		const answers = getAnswers(quiz);
		const clouds = avatar.querySelector('#Cloud--group')?.querySelectorAll('text');
		clouds?.forEach((cloud, index) => {
			if (answers[index]) {
				let cloudTags = getTags(answers[index], 20);
				let x = parseInt(cloud.getAttribute('x')) || 0;
				let y = parseInt(cloud.getAttribute('y')) || 0;
				cloudTags?.map((tag, index) => {
					const tspan = document.createElement( 'TSPAN' );
					tspan.textContent = tag;
					tspan.setAttribute('x', x);
					tspan.setAttribute('y', y);
					cloud.appendChild(tspan);
					y += 20;
				});
			}
		});

		return avatar.outerHTML;
	}

	const svgHtml = prepareAvatar( avatar );

	/**
	 * Parse the SVG string into a DOM.
	 *
	 * @param {string} svg - The SVG string.
	 * @return {Object} The SVG DOM.
	 */
	function parseSvg( svg ) {
		const parser = new DOMParser();
		const doc = parser.parseFromString( svg, 'image/svg+xml' );
		return doc.querySelector( 'svg' );
	}

	return (
		<svg
			xmlns="http://www.w3.org/2000/svg"
			height="100%"
			width="700px"
			version="1.1"
			viewBox="0 0 1000 1000"
			dangerouslySetInnerHTML={ { __html: svgHtml } }
		></svg>
	);
}
