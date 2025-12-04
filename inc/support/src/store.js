import { createReduxStore, register } from '@wordpress/data';

const STORE_NAME = 'wapuugotchi/support';

function create() {
	const store = createReduxStore( STORE_NAME, {
		reducer( state = {}, { type, payload } ) {
			switch ( type ) {
				case '__SET_STATE':
					return {
						...state,
						...payload,
					};
			}
			return state;
		},
		actions: {
			__initialize:
				( initialState ) =>
				( { dispatch } ) => {
					dispatch.__setState( initialState );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
		},
		selectors: {
			getCards( state ) {
				return state.cards ?? [];
			},
		},
		resolvers: {},
	} );

	register( store );
}

create();

export { STORE_NAME };
