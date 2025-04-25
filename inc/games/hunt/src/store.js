import {
	createReduxStore,
	register,
	dispatch as globalDispatch,
} from '@wordpress/data';
import { buildSvg } from './utils/avatarUtils';
import { getTags } from './utils/textUtils';
import apiFetch from '@wordpress/api-fetch';

// Store-Namen für die Hunt- und Missionskomponenten
const STORE_NAME = 'wapuugotchi/hunt';
const MISSION_STORE_NAME = 'wapuugotchi/mission';

/**
 * This function deletes the mission.
 * @param {string} id    - The mission ID.
 * @param {string} nonce - The nonce for the billing.
 */
function __deleteMission( id, nonce ) {
	apiFetch( {
		path: 'wapuugotchi/v1/hunt/delete_mission',
		method: 'POST',
		data: {
			id,
			nonce,
		},
	} );
}

// Definition des Redux Stores
const store = createReduxStore( STORE_NAME, {
	reducer( state = {}, action ) {
		switch ( action.type ) {
			case '__SET_STATE':
				return { ...state, ...action.payload };
			case '__SET_AVATAR':
				return { ...state, avatar: action.payload };
			case '__SET_COMPLETED':
				return { ...state, completed: action.payload };
			default:
				return state;
		}
	},
	actions: {
		__initialize:
			( initialState ) =>
			// eslint-disable-next-line no-shadow
			async ( { dispatch, select } ) => {
				dispatch.__setState( initialState );
				const quest = initialState.data?.quest_text;
				const svg = await buildSvg(
					initialState.avatar,
					getTags( quest, 25 )
				);
				dispatch.setAvatar( svg );

				if ( select.getData()?.state === 'payout' ) {
					globalDispatch( MISSION_STORE_NAME )?.setCompleted();
					__deleteMission(
						select.getData()?.id,
						select.getNonces()?.wapuugotchi_hunt
					);
				}
			},
		__setState: ( payload ) => ( { type: '__SET_STATE', payload } ),
		setAvatar: ( payload ) => ( { type: '__SET_AVATAR', payload } ),
		setCompleted: ( payload ) => ( { type: '__SET_COMPLETED', payload } ),
	},
	selectors: {
		__getState: ( state ) => state,
		getData: ( state ) => state.data,
		getAvatar: ( state ) => state.avatar,
		getCompleted: ( state ) => state.completed,
		getNonces: ( state ) => state.nonces,
	},
} );

register( store );

export { STORE_NAME };
