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
			}

			return state;
		},
		actions: {
			// this is just once used to initialize the store with the initial data
			__initialize: ( initialState ) =>
				async function ( { dispatch, select } ) {
					dispatch.__setState( initialState );

					dispatch.setConfig( select.getConfig() );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
			setConfig ( payload ) {
				return {
					type: '__SET_CONFIG',
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
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
