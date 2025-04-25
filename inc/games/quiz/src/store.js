import {
	createReduxStore,
	register,
	dispatch as globalDispatch,
} from '@wordpress/data';
import { buildSvg } from './utils/avatarUtils';
import { getQuizElement } from './utils/quizUtils';

// Store-Namen für die Quiz- und Missionskomponenten
const STORE_NAME = 'wapuugotchi/quiz';
const MISSION_STORE_NAME = 'wapuugotchi/mission';

// Definition des Redux Stores
const store = createReduxStore( STORE_NAME, {
	reducer( state = {}, action ) {
		switch ( action.type ) {
			case '__SET_STATE':
				return { ...state, ...action.payload };
			case '__SET_AVATAR':
				return { ...state, avatar: action.payload };
			case '__SET_QUIZ':
				return { ...state, quiz: action.payload };
			case '__SET_DATA':
				return { ...state, data: [ ...action.payload ] };
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
				const quiz = await getQuizElement( initialState.data );
				const svg = await buildSvg( initialState.avatar, quiz );
				dispatch.setQuiz( quiz );
				dispatch.setAvatar( svg );
			},
		__setState: ( payload ) => ( { type: '__SET_STATE', payload } ),
		setAvatar: ( payload ) => ( { type: '__SET_AVATAR', payload } ),
		setQuiz: ( payload ) => ( { type: '__SET_QUIZ', payload } ),
		setData:
			( payload ) =>
			async ( { dispatch, select } ) => {
				const quiz = await getQuizElement( select.getData() );
				const svg = await buildSvg( select.getAvatar(), quiz );
				dispatch.setQuiz( quiz );
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
		getQuiz: ( state ) => state.quiz,
	},
} );

register( store );

export { STORE_NAME };
