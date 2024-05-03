import { createReduxStore, register } from '@wordpress/data';
import textBox from './components/assets/text-box.json';

const STORE_NAME = 'wapuugotchi/onboarding';

/**
 * Parse the SVG string into a DOM and modify it.
 *
 * @param {string} svg - The SVG string.
 * @return {string} The modified SVG string.
 */
async function __buildSvg( svg ) {
	const avatar = parseSvg( svg );
	insertOnboardingTag( avatar );
	removeIgnoredElements( avatar );

	return avatar.innerHTML;
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
 * Insert the onboarding tag into the SVG DOM.
 *
 * @param {Object} avatar - The SVG DOM.
 */
function insertOnboardingTag( avatar ) {
	const selectedElement = avatar.querySelector(
		'g#wapuugotchi_type__wapuu, g#wapuugotchi_type__bear'
	);
	selectedElement?.insertBefore(
		__getOnboardingTag(),
		avatar.querySelector( 'g#LeftArm--group' )
	);
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
				case '__SET_INDEX': {
					return {
						...state,
						index: payload,
					};
				}
				case '__SET_ANIMATED': {
					return {
						...state,
						animated: payload,
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
			setIndex( payload ) {
				return {
					type: '__SET_INDEX',
					payload,
				};
			},
			setAnimated( payload ) {
				return {
					type: '__SET_ANIMATED',
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
			getPageConfig( state ) {
				return state.page_config;
			},
			getNextPage( state ) {
				return state.next_page;
			},
			getIndex( state ) {
				return state.index;
			},
			getAnimated( state ) {
				return state.animated;
			},
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
