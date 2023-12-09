import { createReduxStore, register } from '@wordpress/data';

const STORE_NAME = 'wapuugotchi/onboarding';

/**
 * returns the whole state data containing ALMOST ANYTHING
 * should be removed after finishing porting to react
 * exists just for debugging purposes
 *
 * - wp.data.select('wapuugotchi/onboarding').__getState()
 *
 * - wp.data.select('wapuugotchi/onboarding').getCollections()
 *
*/

async function __getCurrentElement( payload ) {
	if( payload?.[0] ) {
		return payload?.[0];
	}
	return undefined;
}
async function __getNextElement( payload ) {
	if( payload?.[1] ) {
		return payload[1];
	}
	return undefined;
}
async function __getLastElement( payload ) {
	if( payload?.[0] ) {
		return payload[0];
	}
	return undefined;
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
				case '__SET_CONFIG': {
					return {
						...state,
						config: payload,
					};
				}
				case '__SET_CURRENT': {
					return {
						...state,
						current: payload,
					};
				}
				case '__SET_NEXT': {
					return {
						...state,
						next: payload,
					};
				}
				case '__SET_LAST': {
					return {
						...state,
						last: payload,
					};
				}
				case '__SET_PAGE': {
					return {
						...state,
						page: payload,
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
					dispatch.setConfig( select.getConfig() );
					dispatch.setCurrent( select.getCurrent() );
					dispatch.setNext( select.getNext() );
					dispatch.setLast( select.getLast() );
					dispatch.setPage( select.getPage() );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
			setConfig ( payload ) {
				return {
					type: '__SET_CURRENT',
					payload: { ...payload },
				};
			},
			setCurrent: ( payload ) => async function ( { dispatch, select } ) {
				const current = await __getCurrentElement( payload );
				console.log( current )

				return dispatch.__setCurrent( current );
			},
			__setCurrent( payload ) {
				return {
					type: '__SET_CURRENT',
					payload: { ...payload },
				};
			},
			setNext ( payload ) {
				return {
					type: '__SET_NEXT',
					payload: { ...payload },
				};
			},
			setLast ( payload ) {
				return {
					type: '__SET_LAST',
					payload: { ...payload },
				};
			},
			setPage ( payload ) {
				return {
					type: '__SET_PAGE',
					payload: { ...payload },
				};
			},
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState( state ) {
				return state;
			},
			getConfig( state ) {
				return state.config;
			},
			getCurrent( state ) {
				return state.current;
			},
			getNext( state ) {
				return state.next;
			},
			getLast( state ) {
				return state.last;
			},
			getPage( state ) {
				return state.page;
			}
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
