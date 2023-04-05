import {createReduxStore, register} from "@wordpress/data";

const STORE_NAME = 'wapuugotchi/wapuugotchi';

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
 *
 * - wp.data.select('wapuugotchi/wapuugotchi').getCategories()
 *
 *    returns an object representation (key=>category name, value=>category image url) of all categories
 */

function create(initial_state = {}) {
	const store = createReduxStore(STORE_NAME, {
		/*
		  don't know if we need it right know
		  but will be very useful if we need async actions
		*/
		// __experimentalUseThunks: true,
		reducer(state = {}, {type, payload}) {
			switch (type) {
				case "INITIALIZE": {
					return {
						...payload,
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
			initialize(payload) {
				return {
					type: "INITIALIZE",
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
			// should not be used except for js console debug purposes
			__getState(state) {
				return state;
			},
			getRestBase(state) {
				return state.restBase;
			},
			getItems(state) {
				return state.items;
			},
			getCategories(state) {
				return state.categories;
			},
			getCollections(state) {
				return state.collections;
			},
			getWapuu(state) {
				return state.wapuu;
			},
			getSvgs(state) {
				return state.svgs;
			}
		},
		resolvers: {
			// __getState() {
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
