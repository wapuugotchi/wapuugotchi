import { createReduxStore, register } from '@wordpress/data';
import clouds from "./components/assets/clouds.json";
import textBox from "./components/assets/text-box.json";

const STORE_NAME = 'wapuugotchi/quiz';

async function __getRandomQuizItem( list ) {
	const index = Math.floor( Math.random() * list.length );
	return list[ index ];
}

/**
 * Parse the SVG string into a DOM and modify it.
 *
 * @param {string} svg - The SVG string.
 * @return {string} The modified SVG string.
 */
async function __buildSvg( svg ) {
	const avatar = parseSvg( svg );
	removeIgnoredElements( avatar );
	insertElement( avatar, __getClouds(), 'g#Front--group' );
	insertElement( avatar, __getTextBox(), 'g#LeftArm--group' );

	return avatar.outerHTML;
}

/**
 * Get the onboarding tag.
 *
 * @return {Object} The onboarding tag.
 */
function __getTextBox() {
	const onboarding = document.createElement( 'g' );
	onboarding.id = 'TextBox--group';
	onboarding.innerHTML = textBox.element;
	return onboarding;
}

/**
 * Get the onboarding tag.
 *
 * @return {Object} The onboarding tag.
 */
function __getClouds() {
	const onboarding = document.createElement( 'g' );
	onboarding.id = 'Cloud--group';
	onboarding.innerHTML = clouds.element;
	return onboarding;
}

/**
 * Insert the onboarding tag into the SVG DOM.
 *
 * @param {Object} avatar - The SVG DOM.
 */
function insertElement( avatar, element, tag ) {
	const selectedElement = avatar.querySelector(
		'g#wapuugotchi_type__wapuu, g#wapuugotchi_type__bear'
	);
	selectedElement?.insertBefore(
		element,
		avatar.querySelector( tag )
	);
}

/**
 * Get the onboarding tag.
 *
 * @return {Object} The onboarding tag.
 */
function __getOnboardingTag() {
	const onboarding = document.createElement( 'g' );
	onboarding.id = 'Onboarding--group';
	onboarding.innerHTML = textBox.element;
	return onboarding;
}

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


/**
 * Remove ignored elements from the SVG DOM.
 *
 * @param {Object} avatar - The SVG DOM.
 */
function removeIgnoredElements( avatar ) {
	__getRemoveList()?.forEach( ( ignore ) => {
		avatar.querySelectorAll( ignore )?.forEach( ( item ) => {
			item?.remove();
		} );
	} );
}

/**
 * Get the list of elements to be removed from the SVG DOM.
 *
 * @return {Array} The list of elements to be removed.
 */
function __getRemoveList() {
	return [
		'style',
		'g#Front--group g',
		'g#RightHand--group g',
		'g#BeforeRightHand--part g',
		'g#BeforeLeftArm--part g',
		'g#Ball--group',
	];
}

function create() {
	const store = createReduxStore( STORE_NAME, {
		reducer( state = {}, { type, payload } ) {
			switch ( type ) {
				case '__SET_STATE': {
					return {
						state,
						...payload,
					};
				}
				case '__SET_AVATAR': {
					return {
						...state,
						avatar: payload,
					};
				}
				case '__SET_QUIZ': {
					return {
						...state,
						quiz: { ...payload },
					};
				}
			}

			return state;
		},
		actions: {
			// this is just once used to initialize the store with the initial data
			__initialize: ( initialState ) =>
				async function ( { dispatch, select } ) {
					dispatch.__setState( initialState );
					dispatch.setQuiz( select.getData() );
					dispatch.setAvatar( select.getAvatar() );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},

			setAvatar: ( payload ) =>
				async function ( { dispatch } ) {
					const svg = await __buildSvg( payload );

					return dispatch.__setAvatar( svg );
				},
			__setAvatar( payload ) {
				return {
					type: '__SET_AVATAR',
					payload,
				};
			},
			setQuiz: ( payload ) =>
				async function ( { dispatch } ) {
					const quiz = await __getRandomQuizItem( payload );
					return dispatch.__setQuiz( quiz );
				},
			__setQuiz( payload ) {
				return {
					type: '__SET_QUIZ',
					payload,
				};
			},
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState( state ) {
				return state;
			},
			getAvatar( state ) {
				return state.avatar;
			},
			getData( state ) {
				return state.data;
			},
			getNonceList( state ) {
				return state.nonce_list;
			},
			getQuiz( state ) {
				return state.quiz;
			},
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
