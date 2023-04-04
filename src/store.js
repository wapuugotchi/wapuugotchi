import {createReduxStore, register} from "@wordpress/data";

const STORE_NAME = 'wapuugotchi/wapuugotchi';

const DEFAULT_STATE = {};

/**
 * - wp.data.select('wapuugotchi/wapuugotchi').getState()
 *
 *    returns the whole state data containing ALMOST ANYTHING
 *    should be removed after finishing porting to react
 *    exists just for debugging purposes
 *
 * - wp.data.select('wapuugotchi/wapuugotchi').getCollections()
 *
 *    contains ALL items (both available(paid or price===0) and unavailable (=> not yet paid))
 *
 * - wp.data.select('wapuugotchi/wapuugotchi').getCategories()
 *
 *    returns an object representation (key=>category name, value=>category image url) of all categories
 */


/**
 * computes the state
 *
 * @param   {object} state  @TODO: add description
 *
 * @return  {object} all (non empty) categories. key is category-name, value id category-image-url
 */
function _evalState(state) {
	return {
		categories: state.categories,
		items: state.items,
		wapuu: state.wapuu,
		svgs: state.svgs
	};
}

function create(initial_state = DEFAULT_STATE) {
	const store = createReduxStore(STORE_NAME, {
		/*
		  don't know if we need it right know
		  but will be very useful if we need async actions
		*/
		// __experimentalUseThunks: true,
		reducer(state = {}, {type, payload}) {
			switch (type) {
				case "SET_STATE": {
					return {
						..._evalState(payload),
					}
				}
				case "SET_ITEMS": {
					return {
						...state,
						items: payload,
					};
				}
				case "SET_WAPUU": {
					return {
						...state,
						wapuu: payload
					};
				}
				case "SET_CATEGORIES" : {
					return {
						...state,
						categories: categories,
					}
				}
				case "SET_SVGS" : {
					return {
						...state,
						svgs: svgs,
					}
				}
			}

			return state;
		},
		actions: {
			setState(payload) {
				return {
					type: "SET_STATE",
					payload,
				};
			},
			setItems(payload) {
				return {
					type: "SET_ITEMS",
					payload,
				};
			},
			setWapuu(payload) {
				return {
					type: "SET_WAPUU",
					payload,
				};
			},
			setCategories(payload) {
				return {
					type: "SET_CATEGORIES",
					payload
				}
			},
			setSvgs(payload) {
				return {
					type: "SET_SVGS",
					payload
				}
			}
		},
		selectors: {
			getState(state) {
				return state;
			},
			getItems(state) {
				return state.items;
			},
			getCategories(state) {
				return state.categories;
			},
			getWapuu(state) {
				return state.wapuu;
			},
			getSvgs(state) {
				return state.svgs;
			}
		},
		resolvers: {
			// getState() {
			//   debugger
			//   if(window['wapuugotchi/wapuugotchi-store-state-initial']===undefined) {
			//     throw new Error("Failed to access initial store data : window['wapuugotchi/wapuugotchi-store-state-initial'] is undefined !");
			//   }
			//   return {
			//     type: "SET_COLLECTIONS",
			//     payload: window['wapuugotchi/wapuugotchi-store-state-initial'],
			//   };
			// }
			getSvgs() {
				const payload = "example svg resolver"
				return {
					type: "SET_SVGS",
					payload,
				};
			}
		}
	});

	register(store);
}

// register the store now (lazy registration is not needed)
create();

export {STORE_NAME};
