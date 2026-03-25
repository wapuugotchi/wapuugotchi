import { createReduxStore, register } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

const STORE_NAME = 'wapuugotchi/settings';

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
			saveSetting:
				( key, value ) =>
				async ( { dispatch, select } ) => {
					const currentSettings = select.getSettings();
					const nonce = select.getNonce();

					const newSettings = { ...currentSettings, [ key ]: value };
					dispatch.__setState( {
						settings: newSettings,
						saving: true,
						saved: false,
					} );

					try {
						await apiFetch( {
							path: '/wapuugotchi/v1/settings/save',
							method: 'POST',
							data: { nonce, settings: newSettings },
						} );
						dispatch.__setState( { saving: false, saved: true } );
					} catch ( e ) {
						dispatch.__setState( {
							settings: currentSettings,
							saving: false,
							saved: false,
						} );
					}
				},
		},
		selectors: {
			getFeatures( state ) {
				return state.features ?? [];
			},
			getSettings( state ) {
				return state.settings ?? {};
			},
			getNonce( state ) {
				return state.nonce ?? '';
			},
			isSaving( state ) {
				return state.saving ?? false;
			},
			isSaved( state ) {
				return state.saved ?? false;
			},
		},
		resolvers: {},
	} );

	register( store );
}

create();

export { STORE_NAME };
