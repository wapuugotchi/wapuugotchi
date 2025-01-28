import {
	createReduxStore,
	register,
	dispatch as globalDispatch,
} from '@wordpress/data';
import { buildSvg } from './utils/avatarUtils';
import { getTags } from './utils/textUtils';

// Store-Namen für die Hunt- und Missionskomponenten
const STORE_NAME = 'wapuugotchi/hunt';
const MISSION_STORE_NAME = 'wapuugotchi/mission';

// Definition des Redux Stores
const store = createReduxStore( STORE_NAME, {
	reducer( state = {}, action ) {
		switch ( action.type ) {
			case '__SET_STATE':
				return { ...state, ...action.payload };
			case '__SET_AVATAR':
				return { ...state, avatar: action.payload };
			default:
				return state;
		}
	},
	actions: {
		__initialize:
			( initialState ) =>
			// eslint-disable-next-line no-shadow
			async ( { dispatch } ) => {
				dispatch.__setState( initialState );
				const quest = initialState.data[ 0 ]?.quest_text;
				const svg = await buildSvg(
					initialState.avatar,
					getTags( quest, 25 )
				);
				dispatch.setAvatar( svg );
			},
		__setState: ( payload ) => ( { type: '__SET_STATE', payload } ),
		setAvatar: ( payload ) => ( { type: '__SET_AVATAR', payload } ),
		setCompleted: () => () => {
			globalDispatch( MISSION_STORE_NAME )?.setCompleted();
		},
	},
	selectors: {
		__getState: ( state ) => state,
		getAvatar: ( state ) => state.avatar,
	},
} );

register( store );

export { STORE_NAME };
