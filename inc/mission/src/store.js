import { createReduxStore, register } from '@wordpress/data';

const STORE_NAME = 'wapuugotchi/mission';

/**
 * Parse the SVG string into a DOM.
 *
 * @param {string} svg - The SVG string.
 * @return {Object} The SVG DOM.
 */
function __buildSvg( string, progress, locked ) {
	const parser = new DOMParser();
	let svg = parser.parseFromString( string, 'image/svg+xml' );
	if ( !locked ) {
		svg = setMission( svg, ( progress + 1 ) );
		svg = setTrack( svg, ( progress + 1 ) );
	} else {
		svg = setTrack( svg, ( progress ) );
	}
	return svg.querySelector( 'svg' ).innerHTML;
}

function setTrack( svg, progress ) {
	for ( let i = 1; i <= progress; i++ ) {
		const track = svg.querySelector( '#track_' + i )
		track?.setAttribute('opacity', '1')
	}

	return svg;
}

function setMission( svg, progress ) {
	const mission = svg.querySelector( '#mission_' + progress )
	mission?.classList.add( 'active' );
	return svg;
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
				case '__SET_MAP': {
					return {
						...state,
						map: payload,
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
				async function ( { dispatch, select } ) {
					dispatch.__setState( initialState );
					dispatch.setMap( select.getMap() );

				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
			setMap: ( payload ) =>
				async function ( { dispatch, select } ) {
					const svg = await __buildSvg( payload, select.getProgress(), select.getLocked() );

					return dispatch.__setMap( svg );
				},
			__setMap( payload ) {
				return {
					type: '__SET_MAP',
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
			getLocked( state ) {
				return state.locked;
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
			getAction( state ) {
				return state.action;
			},
			getNonceList( state ) {
				return state.nonce_list;
			},
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
