import { createReduxStore, register } from '@wordpress/data';

const STORE_NAME = 'wapuugotchi/quiz';

async function __getRandomQuizItem( list ) {
	const index = Math.floor( Math.random() * list.length );
	return list[ index ];
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
				case '__SET_AVATAR': {
					return {
						...state,
						avatar: payload,
					};
				}
				case '__SET_QUIZ': {
					return {
						...state,
						quiz: { ...payload },
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
					dispatch.setQuiz( select.getData() );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
			setAvatar( payload ) {
				return {
					type: '__SET_AVATAR',
					payload,
				};
			},
			setQuiz: ( payload ) =>
				async function ( { dispatch } ) {
					const quiz = await __getRandomQuizItem( payload );
					return dispatch.__setQuiz( quiz );
				},
			__setQuiz( payload ) {
				return {
					type: '__SET_QUIZ',
					payload,
				};
			},
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState( state ) {
				return state;
			},
			getAvatar( state ) {
				return state.avatar;
			},
			getData( state ) {
				return state.data;
			},
			getQuiz( state ) {
				return state.quiz;
			},
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
