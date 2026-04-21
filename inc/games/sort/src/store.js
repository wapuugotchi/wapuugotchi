import {
	createReduxStore,
	register,
	dispatch as globalDispatch,
} from '@wordpress/data';
import { buildSvg } from './utils/avatarUtils';
import { getSortElement } from './utils/sortUtils';

const STORE_NAME = 'wapuugotchi/sort';
const MISSION_STORE_NAME = 'wapuugotchi/mission';

const store = createReduxStore( STORE_NAME, {
	reducer( state = {}, action ) {
		switch ( action.type ) {
			case '__SET_STATE':
				return { ...state, ...action.payload };
			case '__SET_AVATAR':
				return { ...state, avatar: action.payload };
			case '__SET_SORT':
				return { ...state, sort: action.payload };
			case '__SET_DATA':
				return { ...state, data: [ ...action.payload ] };
			default:
				return state;
		}
	},
	actions: {
		__initialize:
			( initialState ) =>
			async ( { dispatch } ) => {
				dispatch.__setState( initialState );
				const sort = await getSortElement( initialState.data );
				const svg = await buildSvg( initialState.avatar, sort );
				dispatch.setSort( sort );
				dispatch.setAvatar( svg );
			},
		__setState: ( payload ) => ( { type: '__SET_STATE', payload } ),
		setAvatar: ( payload ) => ( { type: '__SET_AVATAR', payload } ),
		setSort: ( payload ) => ( { type: '__SET_SORT', payload } ),
		setData:
			( payload ) =>
			async ( { dispatch, select } ) => {
				const sort = await getSortElement( select.getData() );
				const svg = await buildSvg( select.getAvatar(), sort );
				dispatch.setSort( sort );
				dispatch.setAvatar( svg );
				dispatch.__setData( payload );
			},
		__setData: ( payload ) => ( { type: '__SET_DATA', payload } ),
		setCompleted: () => () => {
			globalDispatch( MISSION_STORE_NAME )?.setCompleted();
		},
	},
	selectors: {
		__getState: ( state ) => state,
		getAvatar: ( state ) => state.avatar,
		getData: ( state ) => state.data,
		getSort: ( state ) => state.sort,
	},
} );

register( store );

export { STORE_NAME };
