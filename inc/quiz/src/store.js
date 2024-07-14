import { createReduxStore, register, dispatch } from '@wordpress/data';
import clouds from './components/assets/clouds.json';
import textBox from './components/assets/text-box.json';

// Store-Namen für die Quiz- und Missionskomponenten
const STORE_NAME = 'wapuugotchi/quiz';
const MISSION_STORE_NAME = 'wapuugotchi/mission';

/**
 * Wählt ein zufälliges Quiz-Element aus einer Liste aus.
 * @param {Array} list - Die Liste der Quiz-Elemente.
 * @return {Array} Ein zufälliges Element aus der Liste.
 */
const getRandomQuizItem = ( list ) =>
	list[ Math.floor( Math.random() * list.length ) ];

/**
 * Erstellt ein SVG-Element basierend auf einem SVG-String.
 * @param {string} svgString - Der SVG-String.
 * @return {string} Das bearbeitete SVG als String.
 */
const buildSvg = async ( svgString ) => {
	const parser = new DOMParser();
	const doc = parser.parseFromString( svgString, 'image/svg+xml' );
	const svg = doc.querySelector( 'svg' );
	removeIgnoredElements( svg );
	insertElement( svg, getClouds(), 'g#Front--group' );
	insertElement( svg, getTextBox(), 'g#LeftArm--group' );
	return svg.outerHTML;
};

/**
 * Erstellt ein Textbox-Element für das SVG.
 * @return {Element} Das Textbox-Element.
 */
const getTextBox = () => {
	const onboarding = document.createElement( 'g' );
	onboarding.id = 'TextBox--group';
	onboarding.innerHTML = textBox.element;
	return onboarding;
};

/**
 * Erstellt ein Wolken-Element für das SVG.
 * @return {Element} Das Wolken-Element.
 */
const getClouds = () => {
	const onboarding = document.createElement( 'g' );
	onboarding.id = 'Cloud--group';
	onboarding.innerHTML = clouds.element;
	return onboarding;
};

/**
 * Fügt ein Element in ein SVG ein.
 * @param {Element} svg     - Das SVG-Element.
 * @param {Element} element - Das einzufügende Element.
 * @param {string}  tag     - Der Tag, vor dem das Element eingefügt werden soll.
 */
const insertElement = ( svg, element, tag ) => {
	const selectedElement = svg.querySelector(
		'g#wapuugotchi_type__wapuu, g#wapuugotchi_type__bear'
	);
	selectedElement?.insertBefore( element, svg.querySelector( tag ) );
};

/**
 * Entfernt nicht benötigte Elemente aus einem SVG.
 * @param {Element} svg - Das SVG-Element.
 */
const removeIgnoredElements = ( svg ) => {
	const removeList = [
		'style',
		'g#Front--group g',
		'g#RightHand--group g',
		'g#BeforeRightHand--part g',
		'g#BeforeLeftArm--part g',
		'g#Ball--group',
	];
	removeList.forEach( ( selector ) => {
		svg.querySelectorAll( selector ).forEach( ( elem ) => elem.remove() );
	} );
};

// Definition des Redux Stores
const store = createReduxStore( STORE_NAME, {
	reducer( state = {}, action ) {
		switch ( action.type ) {
			case '__SET_STATE':
				return { ...state, ...action.payload };
			case '__SET_AVATAR':
				return { ...state, avatar: action.payload };
			case '__SET_QUIZ':
				return { ...state, quiz: action.payload };
			default:
				return state;
		}
	},
	actions: {
		__initialize:
			( initialState ) =>
			// eslint-disable-next-line no-shadow
			async ( { dispatch } ) => {
				dispatch.__setState( initialState );
				const quiz = await getRandomQuizItem( initialState.data );
				const svg = await buildSvg( initialState.avatar );
				dispatch.__setQuiz( quiz );
				dispatch.__setAvatar( svg );
			},
		__setState: ( payload ) => ( { type: '__SET_STATE', payload } ),
		__setAvatar: ( payload ) => ( { type: '__SET_AVATAR', payload } ),
		__setQuiz: ( payload ) => ( { type: '__SET_QUIZ', payload } ),
		setCompleted: () => () => {
			dispatch( MISSION_STORE_NAME )?.setCompleted();
		},
	},
	selectors: {
		__getState: ( state ) => state,
		getAvatar: ( state ) => state.avatar,
		getData: ( state ) => state.data,
		getQuiz: ( state ) => state.quiz,
	},
} );

register( store );

export { STORE_NAME };
