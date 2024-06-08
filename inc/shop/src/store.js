import { createReduxStore, register } from '@wordpress/data';
import apiFetch from '@wordpress/api-fetch';

const STORE_NAME = 'wapuugotchi/shop';

/**
 * returns the whole state data containing ALMOST ANYTHING
 * should be removed after finishing porting to react
 * exists just for debugging purposes
 *
 * - wp.data.select('wapuugotchi/wapuugotchi').__getState()
 *
 * - wp.data.select('wapuugotchi/wapuugotchi').getCollections()
 *
 *    contains ALL items (both available(paid or price===0) and unavailable (=> not yet paid))
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
					if ( wapuuSvgGroup ) {
						const removePart =
							wapuuSvgGroup.querySelector( '.remove--part' );
						if ( removePart !== null ) {
							removePart.remove();
						}
						itemGroup.removeAttribute( 'class' );
						wapuuSvgGroup.append( itemGroup );
					}
				} );
			//script tags in svg sollen auf die oberste ebene von wapuuSvgGroup hinzugefügt werden
			Array.from( svg.querySelectorAll( 'style' ) ).forEach(
				( style ) => {
					result.prepend( style );
				}
			);
		}
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
				case '__SET_BALANCE': {
					return {
						...state,
						balance: payload,
					};
				}
				case '__SET_ITEMS': {
					return {
						...state,
						items: payload,
					};
				}
				case '__SET_ITEM_DETAIL': {
					return {
						...state,
						itemDetail: payload,
					};
				}
				case '__SET_SELECTED_CATEGORY': {
					return {
						...state,
						selectedCategory: payload,
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
			purchaseItem: ( item ) =>
				async function ( { dispatch, select } ) {
					await apiFetch( {
						path: `wapuugotchi/v1/wapuugotchi/shop/unlock-item`,
						method: 'POST',
						data: {
							item: {
								key: item.meta.key,
								category: select.getSelectedCategory(),
							},
						},
					} ).then( ( response ) => {
						if ( response.status === '200' ) {
							dispatch.setBalance(
								select.getBalance() - item.meta.price
							);
							item.meta.price = 0;
							dispatch.setItems( select.getItems() );
						}
					} );
				},
			setBalance( payload ) {
				return {
					type: '__SET_BALANCE',
					payload,
				};
			},
			setItems( payload ) {
				return {
					type: '__SET_ITEMS',
					payload: { ...payload },
				};
			},
			showItemDetail( payload ) {
				return {
					type: '__SET_ITEM_DETAIL',
					payload,
				};
			},

			setSelectedCategory( payload ) {
				return {
					type: '__SET_SELECTED_CATEGORY',
					payload,
				};
			},
		},
		selectors: {
			// should not be used except for js console debug purposes
			__getState( state ) {
				return state;
			},
			getItems( state ) {
				return state.items;
			},
			getCategories( state ) {
				return state.categories;
			},
			getWapuu( state ) {
				return state.wapuu;
			},
			getSvg( state ) {
				return state.svg;
			},
			getBalance( state ) {
				return state.balance;
			},
			getItemDetail( state ) {
				return state.itemDetail;
			},
			getSelectedCategory( state ) {
				return state.selectedCategory;
			},
		},
	} );

	register( store );
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
