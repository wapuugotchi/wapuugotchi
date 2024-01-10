import { createReduxStore, register } from '@wordpress/data';
import textBox from './assets/text-box.json';

const STORE_NAME = 'wapuugotchi/onboarding';

/**
 * returns the whole state data containing ALMOST ANYTHING
 * should be removed after finishing porting to react
 * exists just for debugging purposes
 *
 * - wp.data.select('wapuugotchi/onboarding').__getState()
 *
 * - wp.data.select('wapuugotchi/onboarding').getCollections()
 *
*/
const __getItemUrls = ( wapuu, items, category ) => {
	if ( wapuu.char?.[ category ]?.key?.[ 0 ] ) {
		return wapuu.char[ category ].key
			.filter( ( uuid ) => items[ category ][ uuid ] )
			.map( ( uuid ) => items[ category ][ uuid ].image );
	}
	return [];
};

async function __buildSvg( wapuu, items ) {
	const responses = await Promise.all(
		Object.keys( wapuu.char )
			.map( ( category ) =>
				__getItemUrls( wapuu, items, category ).map( ( url ) =>
					fetch( url )
				)
			)
			.flat()
	);

	const ignoreList = ['Front--group', 'RightHand--group', 'BeforeRightHand--part', 'BeforeLeftArm--part', 'Ball--group']
	const svgs = (
		await Promise.all( responses.map( ( response ) => response.text() ) )
	).map( ( _ ) => new DOMParser().parseFromString( _, 'image/svg+xml' ) );
	if ( svgs.length ) {
		const result = svgs
			.splice(
				( svg ) => svg.querySelector( '#wapuugotchi_svg__wapuu' ),
				1
			)[ 0 ]
			.querySelector( '#wapuugotchi_svg__wapuu' );
		for ( const svg of svgs ) {
			Array.from( svg.querySelectorAll( 'g' ) )
				.filter( ( itemGroup ) => itemGroup.classList.value )
				.forEach( ( itemGroup ) => {
					const wapuuSvgGroup = result.querySelector(
						'g#' + itemGroup.classList.value
					);
					if ( wapuuSvgGroup && ignoreList.includes(itemGroup.classList.value) === false ) {
						const removePart =
							wapuuSvgGroup.querySelector( '.remove--part' );
						if ( removePart !== null ) {
							removePart.remove();
						}
						itemGroup.removeAttribute( 'class' );
						wapuuSvgGroup.append( itemGroup );
					}
				} );
		}
		let onboarding = document.createElement( 'g' );
		onboarding.id = 'Onboarding--group';
		onboarding.innerHTML = textBox.element;
		result?.querySelector('g#wapuugotchi_type__wapuu')?.insertBefore(onboarding, result.querySelector('g#LeftArm--group'));
		return result.innerHTML;
	}
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
				case '__SET_WAPUU': {
					return {
						...state,
						wapuu: payload.wapuu,
						svg: payload.svg,
					};
				}
				case '__SET_ITEMS': {
					return {
						...state,
						items: payload,
					};
				}
				case '__SET_GLOBAL_CONFIG': {
					return {
						...state,
						global_config: payload,
					};
				}
				case '__SET_PAGE_CONFIG': {
					return {
						...state,
						page_config: payload,
					};
				}
				case '__SET_PAGE_NAME': {
					return {
						...state,
						page_name: payload,
					};
				}
				case '__SET_INDEX': {
					return {
						...state,
						index: payload,
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

					dispatch.setWapuu( select.getWapuu() );
					dispatch.setItems( select.getItems() );
					dispatch.setGlobalConfig( select.getGlobalConfig() );
					dispatch.setPageConfig( select.getPageConfig() );
					dispatch.setPageName( select.getPageName() );
					dispatch.setIndex( select.getIndex() );
				},
			__setState( payload ) {
				return {
					type: '__SET_STATE',
					payload,
				};
			},
			setWapuu: ( payload ) =>
				async function ( { dispatch, select } ) {
					const svg = await __buildSvg( payload, select.getItems() );

					return dispatch.__setWapuu( payload, svg );
				},
			__setWapuu( wapuu, svg ) {
				return {
					type: '__SET_WAPUU',
					payload: {
						wapuu: { ...wapuu },
						svg,
					},
				};
			},
			setItems( payload ) {
				return {
					type: '__SET_ITEMS',
					payload: { ...payload },
				};
			},
			setGlobalConfig ( payload ) {
				return {
					type: '__SET_GLOBAL_CONFIG',
					payload: payload,
				};
			},
			setPageConfig ( payload ) {
				return {
					type: '__SET_PAGE_CONFIG',
					payload: payload,
				};
			},
			setPageName ( payload ) {
				return {
					type: '__SET_PAGE_NAME',
					payload: payload,
				};
			},
			setIndex ( payload ) {
				return {
					type: '__SET_INDEX',
					payload: payload,
				};
			},
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState( state ) {
				return state;
			},
			getWapuu( state ) {
				return state.wapuu;
			},
			getItems( state ) {
				return state.items;
			},
			getGlobalConfig( state ) {
				return state.global_config;
			},
			getPageConfig( state ) {
				return state.page_config;
			},
			getSvg( state ) {
				return state.svg;
			},
			getPageName( state ) {
				return state.page_name;
			},
			getIndex( state ) {
				return state.index;
			},
		},
		resolvers: {},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
