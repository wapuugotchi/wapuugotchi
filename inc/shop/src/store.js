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

const __getItemData = ( wapuu, items, category ) => {
	if ( wapuu.char?.[ category ]?.key?.[ 0 ] ) {
		return wapuu.char[ category ].key
			.filter( ( uuid ) => items?.[ category ]?.[ uuid ] )
			.map( ( uuid ) => ( {
				url: items[ category ][ uuid ].image,
				itemKey: items[ category ][ uuid ].meta.key,
			} ) );
	}
	return [];
};

function __applyItemColors( srcEl, destEl, itemKey ) {
	srcEl
		.getAttributeNames()
		.filter( ( attr ) => /^data-color-\d+$/.test( attr ) )
		.forEach( ( attr ) => {
			const n = attr.slice( 'data-color-'.length );
			const cssVar = `--wapuu-color-${ itemKey }-${ n }`;
			destEl.setAttribute(
				`data-color-${ itemKey }-${ n }`,
				srcEl.getAttribute( attr )
			);
			if ( srcEl !== destEl ) {
				const value = srcEl.style.getPropertyValue( cssVar ).trim();
				if ( value ) destEl.style.setProperty( cssVar, value );
			} else {
				srcEl.removeAttribute( attr );
			}
		} );
}

async function __buildSvg( wapuu, items ) {
	if ( ! wapuu?.char ) return;
	const itemData = Object.keys( wapuu.char ).flatMap( ( category ) =>
		__getItemData( wapuu, items, category )
	);

	if ( ! itemData.length ) return;

	let texts;
	try {
		texts = await Promise.all(
			itemData.map( ( { url } ) =>
				fetch( url ).then( ( r ) => {
					if ( ! r.ok ) throw new Error( r.status );
					return r.text();
				} )
			)
		);
	} catch {
		return;
	}

	const svgsWithKey = texts.map( ( text, i ) => ( {
		itemKey: itemData[ i ].itemKey,
		svg: new DOMParser().parseFromString(
			text.replaceAll(
				'--wapuu-color-',
				`--wapuu-color-${ itemData[ i ].itemKey }-`
			),
			'image/svg+xml'
		),
	} ) );

	let baseIndex = svgsWithKey.findIndex( ( { svg } ) =>
		svg.querySelector( '#wapuugotchi_svg__wapuu' )
	);
	if ( baseIndex === -1 ) {
		baseIndex = svgsWithKey.findIndex( ( { svg } ) =>
			svg.querySelector( '#wapuugotchi_svg__item' )
		);
	}
	if ( baseIndex === -1 ) return;

	const [ { itemKey: baseKey, svg: baseSvgDoc } ] = svgsWithKey.splice(
		baseIndex,
		1
	);
	const result =
		baseSvgDoc.querySelector( '#wapuugotchi_svg__wapuu' ) ??
		baseSvgDoc.querySelector( '#wapuugotchi_svg__item' );
	if ( ! result.classList.contains( 'color_pick_able' ) ) {
		result.classList.add( 'color_pick_able' );
	}

	__applyItemColors( result, result, baseKey );

	for ( const { itemKey, svg } of svgsWithKey ) {
		__applyItemColors( svg.documentElement, result, itemKey );

		Array.from( svg.querySelectorAll( 'g' ) )
			.filter( ( itemGroup ) => itemGroup.classList.length === 1 )
			.forEach( ( itemGroup ) => {
				const wapuuSvgGroup = result.querySelector(
					'g#' + CSS.escape( itemGroup.classList[ 0 ] )
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
		Array.from( svg.querySelectorAll( 'style' ) ).forEach( ( style ) => {
			result.prepend( style );
		} );
	}

	if ( wapuu.colors ) {
		Object.entries( wapuu.colors ).forEach( ( [ variable, value ] ) => {
			result.style.setProperty( variable, value );
		} );
	}

	return result.outerHTML;
}

let _svgGeneration = 0;

function create() {
	const store = createReduxStore( STORE_NAME, {
		reducer( state = {}, { type, payload } ) {
			switch ( type ) {
				case '__SET_STATE': {
					return {
						...state,
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
					const generation = ++_svgGeneration;
					const svg = await __buildSvg( payload, select.getItems() );
					if ( generation === _svgGeneration ) {
						return dispatch.__setWapuu( payload, svg );
					}
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
					const price = item.meta.price;
					const category = select.getSelectedCategory();
					try {
						const response = await apiFetch( {
							path: `wapuugotchi/v1/wapuugotchi/shop/unlock-item`,
							method: 'POST',
							data: {
								item: {
									key: item.meta.key,
									category,
								},
							},
						} );
						if ( response.status === '200' ) {
							dispatch.setBalance( select.getBalance() - price );
							const currentItems = select.getItems();
							dispatch.setItems( {
								...currentItems,
								[ category ]: {
									...currentItems[ category ],
									[ item.meta.key ]: {
										...currentItems[ category ][ item.meta.key ],
										meta: {
											...currentItems[ category ][ item.meta.key ].meta,
											price: 0,
										},
									},
								},
							} );
							return true;
						}
					} catch {
						// network error
					}
					return false;
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
			updateWapuuColor: ( variable, value ) =>
				function ( { dispatch, select } ) {
					const wapuu = select.getWapuu();
					const colors = { ...wapuu?.colors, [ variable ]: value };
					dispatch.__setWapuu(
						{ ...wapuu, colors },
						select.getSvg()
					);
				},
			resetWapuuColors: () =>
				async function ( { dispatch, select } ) {
					const generation = ++_svgGeneration;
					const wapuu = { ...select.getWapuu(), colors: {} };
					const svg = await __buildSvg( wapuu, select.getItems() );
					if ( generation === _svgGeneration ) {
						return dispatch.__setWapuu( wapuu, svg );
					}
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
