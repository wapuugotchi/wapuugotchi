import { createReduxStore, register } from '@wordpress/data';
console.log('pups');
const STORE_NAME = 'wapuugotchi/alive';

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
				case '__ANIMATIONS': {
					return {
						...state,
						animations: payload,
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
				},
			__setState: ( payload ) => (
				{
					type: '__SET_STATE',
					payload
				}
			),
			animations: ( payload ) => (
				{
					type: '__ANIMATIONS',
					payload
				}
			),
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState: ( state ) => state,
			getAnimations: ( state ) => state.animations,
		},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
