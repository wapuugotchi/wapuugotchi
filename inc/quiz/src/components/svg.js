import { useSelect, useRegistry, useDispatch } from '@wordpress/data';
import './svg.scss';
import { STORE_NAME } from '../store';
import { useCallback, useEffect, useState } from '@wordpress/element';

/**
 * Parse the SVG string into a DOM.
 *
 * @param {string} svg - The SVG string.
 * @return {Object} The SVG DOM.
 */
const parseSvg = ( svg ) => {
	const parser = new DOMParser();
	const doc = parser.parseFromString( svg, 'image/svg+xml' );
	return doc.querySelector( 'svg' );
};

/**
 * Get the list of tags from a sentence.
 *
 * @param {string} sentence - The sentence to get tags from.
 * @param {number} length   - The maximum length of a tag.
 * @return {Array} The list of tags.
 */
const getTags = ( sentence, length ) => {
	const tags = [];
	let tag = '';
	const words = sentence.split( ' ' );

	words.forEach( ( word ) => {
		if ( tag.length + word.length > length ) {
			tags.push( tag );
			tag = word;
		} else {
			tag += ' ' + word;
		}
	} );

	tags.push( tag );
	return tags;
};

/**
 * Get the mixed answers and the index of the correct answer.
 *
 * @param {Object} quiz - The quiz data.
 * @return {Object} The mixed answers and the index of the correct answer.
 */
const getAnswers = ( quiz ) => {
	let answers = quiz.wrongAnswers
		.sort( () => Math.random() - 0.5 )
		.slice( 0, 2 );
	answers.push( quiz.correctAnswer );
	answers = answers.sort( () => Math.random() - 0.5 );

	// find the correct answer index in the mixed answers for later use
	const correctAnswerIndex = answers.findIndex(
		( answer ) => answer === quiz.correctAnswer
	);

	return { answers, correctAnswerIndex };
};

/**
 * The Svg component. It renders the avatar SVG with the quiz data.
 *
 * @return {Object} The rendered component.
 */
export default function Svg() {
	const { setCompleted } = useDispatch( STORE_NAME );
	const { avatar, quiz } = useSelect( ( select ) => {
		return {
			avatar: select( STORE_NAME ).getAvatar(),
			quiz: select( STORE_NAME ).getQuiz(),
		};
	} );

	const registry = useRegistry();
	const [ currentIndex, setCurrentIndex ] = useState( null );
	const [ mixedAnswers, setMixedAnswers ] = useState( null );

	/**
	 * Create a TSPAN element with given tag, x and y attributes.
	 *
	 * @param {string} tag - The text content of the TSPAN element.
	 * @param {number} x   - The x attribute of the TSPAN element.
	 * @return {Object} The created TSPAN element.
	 */
	const createTspan = ( tag, x ) => {
		const tspan = document.createElementNS(
			'http://www.w3.org/2000/svg',
			'tspan'
		);
		tspan.textContent = tag;
		tspan.setAttribute( 'x', x );
		tspan.setAttribute( 'dy', '1.2em' );
		return tspan;
	};

	/**
	 * Append tags to a given element with specified x and y attributes.
	 *
	 * @param {Object} element - The element to append tags to.
	 * @param {Array}  tags    - The list of tags to append.
	 * @param {number} x       - The x attribute for the tags.
	 */
	const appendTagsToElement = ( element, tags, x ) => {
		tags.forEach( ( tag ) => {
			const tspan = createTspan( tag, x );
			element.appendChild( tspan );
		} );
	};

	/**
	 * Prepare the TextBox part of the avatar SVG.
	 *
	 * @param {Object}   avatarData  - The avatar SVG DOM.
	 * @param {Object}   quizData    - The quiz data.
	 * @param {Function} getTagsData - The function to get tags from a sentence.
	 * @return {void}
	 */
	const prepareTextBox = ( avatarData, quizData, getTagsData ) => {
		const textBoxTags = getTagsData( quizData.question, 25 );
		const x =
			parseInt(
				avatarData
					.querySelector( '#TextBox--group' )
					?.querySelector( 'text' )
					?.getAttribute( 'x' )
			) || 0;
		const y =
			parseInt(
				avatarData
					.querySelector( '#TextBox--group' )
					?.querySelector( 'text' )
					?.getAttribute( 'y' )
			) || 0;
		appendTagsToElement(
			avatarData
				.querySelector( '#TextBox--group' )
				?.querySelector( 'text' ),
			textBoxTags,
			x,
			y
		);
	};

	/**
	 * Prepare the Clouds part of the avatar SVG.
	 *
	 * @param {Object}   avatarData       - The avatarData SVG DOM.
	 * @param {Array}    mixedAnswersData - The mixed answers from the quiz.
	 * @param {Function} getTagsData      - The function to get tags from a sentence.
	 */
	const prepareClouds = ( avatarData, mixedAnswersData, getTagsData ) => {
		const cloudPosition = 56;
		const clouds = avatarData
			.querySelector( '#Cloud--group' )
			?.querySelectorAll( '.cloud' );
		clouds?.forEach( ( cloud, index ) => {
			if ( mixedAnswersData[ index ] ) {
				const path = cloud.querySelector( 'path' );
				path.setAttribute( 'index', index );

				const text = cloud.querySelector( 'text' );
				const cloudTags = getTagsData( mixedAnswersData[ index ], 20 );

				text.setAttribute( 'y', cloudPosition - cloudTags.length * 8 );
				const x = parseInt( text.getAttribute( 'x' ) ) || 0;

				appendTagsToElement( text, cloudTags, x );
			}
		} );
	};

	useEffect( () => {
		const handleCloudClick = ( event ) => {
			let notice = getTags( quiz.incorrect_notice, 25 );
			let color = '#900';
			let success = false;
			if (
				event.target.getAttribute( 'index' ) === currentIndex.toString()
			) {
				notice = getTags( quiz.correct_notice, 25 );
				color = '#090';
				success = true;
			}
			const messageTag = document
				.querySelector( '.wapuugotchi_mission__action' )
				?.querySelector( '#TextBox--group' )
				?.querySelector( 'text' );
			const cloudGroup = document
				.querySelector( '.wapuugotchi_mission__action' )
				?.querySelector( '#Cloud--group' );
			cloudGroup.classList.add( 'fade-out' );
			//lösche alle tags die in massageTag sind
			while ( messageTag.firstChild ) {
				messageTag.removeChild( messageTag.firstChild );
			}

			messageTag.setAttribute( 'fill', color );
			appendTagsToElement( messageTag, notice, 155, 250 );

			if ( success ) {
				setCompleted();
			}

			const clouds = cloudGroup?.querySelectorAll( '.cloud' );
			clouds?.forEach( ( cloud ) => {
				const path = cloud.querySelector( 'path' );
				path.removeEventListener( 'click', handleCloudClick );
			} );

			//make wapuugotchi_mission__action permeable
			const action = document.querySelector(
				'.wapuugotchi_mission__action'
			);
			action.classList.add( 'permeable' );
		};
		const clouds = document
			.querySelector( '.wapuugotchi_mission__action' )
			?.querySelector( 'svg' )
			?.querySelectorAll( '.cloud' );
		clouds?.forEach( ( cloud ) => {
			const path = cloud.querySelector( 'path' );
			path.addEventListener( 'click', handleCloudClick );
		} );
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [ currentIndex ] );

	/**
	 * Prepare the avatar SVG.
	 *
	 * @param {string} svg - The SVG string.
	 * @return {string} The prepared SVG string.
	 */
	const prepareAvatar = useCallback(
		( svg ) => {
			if ( currentIndex === null || mixedAnswers === null ) {
				return null;
			}

			const parsedAvatar = parseSvg( svg );
			prepareTextBox( parsedAvatar, quiz, getTags );
			prepareClouds( parsedAvatar, mixedAnswers, getTags );

			return parsedAvatar.innerHTML;
			// eslint-disable-next-line react-hooks/exhaustive-deps
		},
		// eslint-disable-next-line react-hooks/exhaustive-deps
		[ currentIndex, mixedAnswers ]
	);

	/**
	 * React useEffect hook for handling side effects in the component.
	 *
	 * This hook is triggered when the `quiz` prop changes. When this happens, it:
	 * 1. Calls the `getAnswers` function with the new `quiz` to get the mixed answers and the index of the correct answer.
	 * 2. Updates the `mixedAnswers` and `currentIndex` state variables with the new values.
	 */
	useEffect( () => {
		if ( quiz ) {
			const { answers, correctAnswerIndex } = getAnswers( quiz );
			registry.batch( () => {
				setMixedAnswers( answers );
				setCurrentIndex( correctAnswerIndex );
			} );
		}
		// eslint-disable-next-line react-hooks/exhaustive-deps
	}, [ quiz ] );

	return (
		<div className="wapuugotchi_mission__action">
			<svg
				id="wapuugotchi_quiz__svg"
				xmlns="http://www.w3.org/2000/svg"
				height="100%"
				width="100%"
				version="1.1"
				viewBox="0 0 1000 1000"
				dangerouslySetInnerHTML={ { __html: prepareAvatar( avatar ) } }
			></svg>
		</div>
	);
}
