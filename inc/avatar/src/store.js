import { createReduxStore, register } from '@wordpress/data';

const STORE_NAME = 'wapuugotchi/avatar';

/**
 * returns the whole state data containing ALMOST ANYTHING
 * should be removed after finishing porting to react
 * exists just for debugging purposes
 *
 * - wp.data.select('wapuugotchi/wapuugotchi').__getState()
 *
 * - wp.data.select('wapuugotchi/wapuugotchi').getCollections()
 *
 *    contains ALL items (both available(paid or price===0) and unavailable (=> not yet paid))
 */

async function __getInnerSvg( avatar ) {
	const svg = new DOMParser().parseFromString( avatar, 'image/svg+xml' );
	return svg?.querySelector( 'svg' )?.innerHTML;
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
						avatar: payload.avatar,
					};
				}
				case '__SET_MESSAGES': {
					return {
						...state,
						messages: payload.messages,
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
					return dispatch.__setAvatar(
						await __getInnerSvg( payload )
					);
				},
			__setAvatar( avatar ) {
				return {
					type: '__SET_AVATAR',
					payload: {
						avatar,
					},
				};
			},
			setMessages( payload ) {
				return {
					type: '__SET_MESSAGES',
					payload: {
						messages: [ ...payload ],
					},
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
			getMessages( state ) {
				return state.messages;
			},
		},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
