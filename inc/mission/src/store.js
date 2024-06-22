import { createReduxStore, register } from '@wordpress/data';

const STORE_NAME = 'wapuugotchi/mission';

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
				case '__SET_PROGRESS': {
					return {
						...state,
						progress: payload,
					};
				}
				case '__SET_MARKERS': {
					return {
						...state,
						markers: payload,
					};
				}
				case '__SET_NONCE': {
					return {
						...state,
						nonce: payload,
					};
				}
				case '__SET_AJAX_URL': {
					return {
						...state,
						ajaxurl: payload,
					};
				}
			}

			return state;
		},
		actions: {
			// this is just once used to initialize the store with the initial data
			__initialize: ( initialState ) =>
				async function ( { dispatch } ) {
					dispatch.__setState( initialState );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
			setProgress( payload ) {
				return {
					type: '__SET_PROGRESS',
					payload,
				};
			},
			setNonce( payload ) {
				return {
					type: '__SET_NONCE',
					payload,
				};
			},
			setAjaxUrl( payload ) {
				return {
					type: '__SET_AJAX_URL',
					payload,
				};
			},
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState( state ) {
				return state;
			},
			getProgress( state ) {
				return state.progress;
			},
			getMarkers( state ) {
				return state.markers;
			},
			getReward( state ) {
				return state.reward;
			},
			getDescription( state ) {
				return state.description;
			},
			getMap( state ) {
				return state.map;
			},
			getNonce( state ) {
				return state.nonce;
			},
			getAjaxUrl( state ) {
				return state.ajaxurl;
			},
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
