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
	const list = Object.values(payload);

	if( list?.[0] ) {
		return list?.[0];
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
				case '__SET_GLOBAL_CONFIG': {
					return {
						...state,
						global_config: payload,
					};
				}
				case '__SET_PAGE_CONFIG': {
					return {
						...state,
						page_config: payload,
					};
				}
				case '__SET_PAGE_NAME': {
					return {
						...state,
						page_name: payload,
					};
				}
				case '__SET_INDEX': {
					return {
						...state,
						index: payload,
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
					dispatch.setGlobalConfig( select.getGlobalConfig() );
					dispatch.setPageConfig( select.getPageConfig() );
					dispatch.setPageName( select.getPageName() );
					dispatch.setIndex( select.getIndex() );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
			setGlobalConfig ( payload ) {
				return {
					type: '__SET_GLOBAL_CONFIG',
					payload: payload,
				};
			},
			setPageConfig ( payload ) {
				return {
					type: '__SET_PAGE_CONFIG',
					payload: payload,
				};
			},
			setPageName ( payload ) {
				return {
					type: '__SET_PAGE_NAME',
					payload: payload,
				};
			},
			setIndex ( payload ) {
				return {
					type: '__SET_INDEX',
					payload: payload,
				};
			},
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState( state ) {
				return state;
			},
			getGlobalConfig( state ) {
				return state.global_config;
			},
			getPageConfig( state ) {
				return state.page_config;
			},
			getPageName( state ) {
				return state.page_name;
			},
			getIndex( state ) {
				return state.index;
			},
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
