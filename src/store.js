import { createReduxStore, register, select } from "@wordpress/data";
import apiFetch from "@wordpress/api-fetch";

const STORE_NAME = "wapuugotchi/wapuugotchi";

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

const __getItemUrls = (wapuu, items, category) => {
	if (wapuu.char?.[category]?.key?.[0]) {
		return wapuu.char[category].key
			.filter((uuid) => items[category][uuid])
			.map((uuid) => items[category][uuid].image);
	}
	return [];
};

async function __buildSvg(wapuu, items) {
	const responses = await Promise.all(
		Object.keys(wapuu.char)
			.map((category) =>
				__getItemUrls(wapuu, items, category).map((url) => fetch(url))
			)
			.flat()
	);

	const svgs = (
		await Promise.all(responses.map((response) => response.text()))
	).map((_) => new DOMParser().parseFromString(_, "image/svg+xml"));
	if (svgs.length) {
		const result = svgs
			.splice((svg) => svg.querySelector("#wapuugotchi_svg__wapuu"), 1)[0]
			.querySelector("#wapuugotchi_svg__wapuu");
		for (const svg of svgs) {
			Array.from(svg.querySelectorAll("g"))
				.filter((itemGroup) => itemGroup.classList.value)
				.forEach((itemGroup) => {
					const wapuu_svg_group = result.querySelector(
						"g#" + itemGroup.classList.value
					);
					if (wapuu_svg_group) {
						itemGroup.removeAttribute("class");
						wapuu_svg_group.append(itemGroup);
					}
				});
		}
		return result.innerHTML;
	}
}

function create(initial_state = {}) {
	const store = createReduxStore(STORE_NAME, {
		reducer(state = {}, { type, payload }) {
			switch (type) {
				case "__SET_STATE": {
					return {
						state,
						...payload,
					};
				}
				case "__SET_WAPUU": {
					return {
						...state,
						wapuu: payload.wapuu,
						svg: payload.svg,
					};
				}
				case "__SET_BALANCE": {
					return {
						...state,
						balance: payload,
					};
				}
				case "__SET_ITEMS": {
					return {
						...state,
						items: payload,
					};
				}
				case "__SET_INTENTION": {
					return {
						...state,
						intention: payload,
					};
				}
			}

			return state;
		},
		actions: {
			// this is just once used to initialize the store with the initial data
			__initialize: (initialState) =>
				async function ({ dispatch, registry, resolveSelect, select }) {
					dispatch.__setState(initialState);

					dispatch.setWapuu(select.getWapuu());
					dispatch.setBalance(select.getBalance());
					dispatch.setItems(select.getItems());
					dispatch.setIntention(select.getIntention());
				},
			__setState(payload) {
				return {
					type: "__SET_STATE",
					payload,
				};
			},
			setWapuu: (payload) =>
				async function ({ dispatch, registry, resolveSelect, select }) {
					const svg = await __buildSvg(payload, select.getItems());

					return dispatch.__setWapuu(payload, svg);
				},
			__setWapuu(wapuu, svg) {
				return {
					type: "__SET_WAPUU",
					payload: {
						wapuu: { ...wapuu },
						svg,
					},
				};
			},
			purchaseItem: (item_data) =>
				async function ({ dispatch, registry, resolveSelect, select }) {
					const success = await apiFetch({
						path: `${select.getRestBase()}/purchases`,
						method: 'POST',
						data: {
							item: {
								key: item_data.meta.key,
								price: item_data.meta.price,
							}},
					});

					// we don't need to check if the api call was successful
					// => await will throw an exception in case of http status >= 400
					dispatch.setBalance(select.getBalance() - item_data.meta.price);
					// (1) since we modify the item price
					item_data.meta.price = 0;
					// (2) we need to tell react about it
					// (=> setItems will create a new instance of the given items which in turn triggers react to re render)
					dispatch.setItems(select.getItems());
				},
			setBalance(payload) {
				return {
					type: "__SET_BALANCE",
					payload,
				};
			},
			setItems(payload) {
				return {
					type: "__SET_ITEMS",
					payload: { ...payload },
				};
			},
			setIntention(payload) {
				return {
					type: "__SET_INTENTION",
					payload: { ...payload },
				};
			},
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
			getCollections(state) {
				return state.collections;
			},
			getCategories(state) {
				return state.categories;
			},
			getWapuu(state) {
				return state.wapuu;
			},
			getSvg(state) {
				return state.svg;
			},
			getBalance(state) {
				return state.balance;
			},
			getIntention(state) {
				return state.intention;
			},
		},
		resolvers: {
			// __getState() {
			//   if(window['wapuugotchi/wapuugotchi-store-state-initial']===undefined) {
			//     throw new Error("Failed to access initial store data : window['wapuugotchi/wapuugotchi-store-state-initial'] is undefined !");
			//   }
			//   return {
			//     type: "SET_COLLECTIONS",
			//     payload: window['wapuugotchi/wapuugotchi-store-state-initial'],
			//   };
			// }
			// getSvgs() {
			// 	const payload = "example svg resolver"
			// 	return {
			// 		type: "SET_SVGS",
			// 		payload,
			// 	};
			// }
		},
	});

	register(store);
}

// register the store now (lazy registration is not needed)
create();

export { STORE_NAME };
