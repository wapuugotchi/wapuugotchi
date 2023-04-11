import {cloneElement, createElement, useEffect, useState, useRef } from "@wordpress/element";
import { STORE_NAME, store } from "../store";
import { useSelect, subscribe } from '@wordpress/data';
import "./ShowRoom.css";
import "./Animation.css";

const ShowRoom = (props) => {

	const [svg, setSvg] = useState([]);
	const { items, categories, wapuu } = useSelect( select => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
			categories: select(STORE_NAME).getCategories(),
		}
	});

	const getItemUrls = (category) => {
		let url = []
		if(wapuu.char && wapuu.char[category] && wapuu.char[category].key && wapuu.char[category].key[0]) {
			wapuu.char[category].key.forEach((uuid) => {
				let item = items[category][uuid]
				if(item) {
					url.push(item.image)
				}
			})
		}
		return url
	}
	const buildSvg = () => {
		let category_list = Object.keys(wapuu.char)
		let promise_array = []

		category_list.forEach((category) => {
			let item_urls = getItemUrls(category)
			if( item_urls.length > 0 ) {
				item_urls.forEach( ( item_url ) => {
					promise_array.push(fetch(item_url))
				} )
			}
		})

		Promise.all(promise_array).then(responses => {
			let getTextPromises = []
			let texts = []

			responses.forEach((res) => getTextPromises.push(res.text().then((text) => {
				texts.push(text)
			})))

			Promise.all(getTextPromises).then(() => {
				mergeSvg(texts)
			})}).catch(err => console.error(err))
	}

	const mergeSvg = (svgArray) => {
		let result;
		svgArray.forEach((svg_string, index) => {
			let svg = new DOMParser().parseFromString(svg_string, "image/svg+xml");
			if(svg.querySelector('#wapuugotchi_svg__wapuu') !== null) {
				result = svg.querySelector('#wapuugotchi_svg__wapuu')
				svgArray.splice(index, 1)
			}
		})


		svgArray.forEach((svg_string, index) => {
			let svg = new DOMParser().parseFromString(svg_string, "image/svg+xml");
			let groups = svg.querySelectorAll('g');
			if (groups.length > 0) {
				groups.forEach((group) => {
					if( group.classList.value ) {
						result.querySelector('g#' + group.classList.value)
						let wapuu_svg_group = result.querySelector('g#' + group.classList.value);
						if (wapuu_svg_group) {
							group.removeAttribute('class')
							wapuu_svg_group.append(group)
						}
					}
				})
			}
		})
		if(result.innerHTML !== svg) {
			setSvg(result.innerHTML);
		}
		console.log('finish')
	}

	// @TODO: buildSvg() needs to be moved into the store
	// this solution is just a workaround ...
	const subscribed = useRef(null);
	if(subscribed.current===null) {
		buildSvg();
		subscribed.current = subscribe(() => {
			buildSvg();
		}, STORE_NAME);
	}

	return (
		<div className="wapuu_show_room">
			{/*		changes to the ViewBox can destroy the animations.		*/}
			<svg xmlns="http://www.w3.org/2000/svg" x="0" y="0" version="1.1" viewBox="140 100 700 765"
					 dangerouslySetInnerHTML={{__html: svg}}></svg>
		</div>
	);
};
export default ShowRoom;
