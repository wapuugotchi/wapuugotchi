import { createReduxStore, register } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

const STORE_NAME = 'wapuugotchi/mission';

/**
 * This function ensures that after the end of the entire mission, the user receives the reward.
 * @param {number} reward - The reward for completing the mission.
 * @param {string} nonce  - The nonce for the billing.
 */
function __completeMission( reward, nonce ) {
	apiFetch( {
		path: 'wapuugotchi/v1/wapuugotchi/balance/raise_balance',
		method: 'POST',
		data: {
			nonce,
			reward,
		},
	} );
}

/**
 * Parse the SVG string into a DOM.
 *
 * @param {string}  string   - The SVG string to be parsed.
 * @param {number}  progress - The current progress of the mission.
 * @param {boolean} locked   - Indicates if the mission is locked.
 * @return {string} The modified SVG string.
 */
function __buildSvg( string, progress, locked ) {
	const parser = new DOMParser();
	let svg = parser.parseFromString( string, 'image/svg+xml' );
	if ( ! locked ) {
		svg = __setMission( svg, progress + 1 );
		svg = __setTrack( svg, progress + 1 );
	} else {
		svg = __setTrack( svg, progress );
	}
	return svg.querySelector( 'svg' ).innerHTML;
}

/**
 * Set the track's opacity based on the progress.
 *
 * @param {Document} svg      - The SVG DOM to modify.
 * @param {number}   progress - The current progress of the mission.
 * @return {Document} The modified SVG DOM.
 */
function __setTrack( svg, progress ) {
	for ( let i = 1; i <= progress; i++ ) {
		const track = svg.querySelector( `#track_${ i }` );
		track?.setAttribute( 'opacity', '1' );
	}
	return svg;
}

/**
 * Activate the mission based on the progress.
 *
 * @param {Document} svg      - The SVG DOM to modify.
 * @param {number}   progress - The current progress of the mission.
 * @return {Document} The modified SVG DOM.
 */
function __setMission( svg, progress ) {
	const mission = svg.querySelector( `#mission_${ progress }` );
	mission?.classList.add( 'active' );
	return svg;
}

/**
 * Initializes and registers the store.
 */
function create() {
	const store = createReduxStore( STORE_NAME, {
		reducer( state = {}, { type, payload } ) {
			switch ( type ) {
				case '__SET_STATE':
					return { ...state, ...payload };
				case '__SET_PROGRESS':
					return { ...state, progress: payload };
				case '__SET_MARKERS':
					return { ...state, markers: payload };
				case '__SET_MAP':
					return { ...state, map: payload };
				case '__SET_AJAX_URL':
					return { ...state, ajaxurl: payload };
				case '__SET_COMPLETED':
					return { ...state, completed: payload };
				default:
					return state;
			}
		},
		actions: {
			__initialize:
				( initialState ) =>
				async ( { dispatch } ) => {
					dispatch.__setState( initialState );
					dispatch.setMap( initialState.map );
				},
			__setState: ( payload ) => ( { type: '__SET_STATE', payload } ),
			setMap:
				( payload ) =>
				async ( { dispatch, select } ) => {
					const svg = __buildSvg(
						payload,
						select.getProgress(),
						select.getLocked()
					);
					dispatch.__setMap( svg );
				},
			__setMap: ( payload ) => ( { type: '__SET_MAP', payload } ),
			setProgress: ( payload ) => ( { type: '__SET_PROGRESS', payload } ),
			setAjaxUrl: ( payload ) => ( { type: '__SET_AJAX_URL', payload } ),
			setCompleted:
				() =>
				async ( { dispatch, select } ) => {
					apiFetch( {
						path: `wapuugotchi/v1/mission/set_completed`,
						method: 'POST',
						data: {
							nonce: select.getNonceList().wapuugotchi_mission,
						},
					} ).then( ( response ) => {
						if ( response.status === '200' ) {
							dispatch.__setCompleted( true );
							dispatch.setProgress( select.getProgress() + 1 );

							// try to complete the hole mission
							if (
								select.getProgress() === select.getMarkers()
							) {
								__completeMission(
									select.getReward(),
									select.getNonceList().wapuugotchi_balance
								);
							}
						}
					} );
				},
			__setCompleted: ( payload ) => ( {
				type: '__SET_COMPLETED',
				payload,
			} ),
		},
		selectors: {
			getProgress: ( state ) => state.progress,
			getLocked: ( state ) => state.locked,
			getMarkers: ( state ) => state.markers,
			getReward: ( state ) => state.reward,
			getDescription: ( state ) => state.description,
			getMap: ( state ) => state.map,
			getNonceList: ( state ) => state.nonce_list,
			getCompleted: ( state ) => state.completed,
		},
	} );

	register( store );
}

create();

export { STORE_NAME };
