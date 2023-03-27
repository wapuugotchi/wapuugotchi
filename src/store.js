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

/*
  import { useSelect } from "@wordpress/data";
  import { STORE_NAME } from './store.js';

  function YourComponent(props) {
    const { wapuu, collections, categories } = useSelect( select => {
      return {
        collections: select(STORE_NAME).getState().collections,
        wapuu: select(STORE_NAME).getWapuu(),
        categories: select(STORE_NAME).getCategories(),
      };
    });

    return <div>{foo}</div>;
  }
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
		wapuu: state.wapuu
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
		}
	});

	register(store);
}

// register the store now (lazy registration is not needed)
create();

/**
 * computes all items from given collections by category
 *
 * @param   {object}  items  @TODO:
 * @param   {string}  category     name of category
 *
 * @return  {array}   array of items of this category
 */
function getItemsByCategory(items, category) {
	return items[category]
}

export {STORE_NAME, getItemsByCategory};
