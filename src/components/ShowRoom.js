import {createElement, useEffect, useState} from "@wordpress/element";
import { STORE_NAME, store } from "../store";
import { useSelect, subscribe } from '@wordpress/data';
import "./ShowRoom.css";

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

	const getSvgString = (data) => {
		return data;
	}

	const buildSvg = () => {
		let data = []
		let category_list = Object.keys(wapuu.char)
		let promise_array = [];
		let item_count = 0;

		category_list.forEach((category) => {
			let item_urls = getItemUrls(category);
			if( item_urls.length > 0 ) {
				item_urls.forEach( ( item_url ) => {
					promise_array.push(fetch(item_url));
					item_count++
				} )

			}
		})

		const allPromise = Promise.all(promise_array);
		allPromise.then(responses =>
			responses.forEach((res) => res.text().then((text) => {
				data.push({text})
				item_count--
				if (item_count <= 0) {
					let result = '';

					data.forEach((svg_string, index) => {
						let svg = new DOMParser().parseFromString(svg_string.text, "image/svg+xml");
						if(svg.querySelector('#wapuu_svg') !== null) {
							result = svg.querySelector('#wapuu_svg')
							data.splice(index, 1)
						}
					})
					data.forEach((svg_string, index) => {
						let svg = new DOMParser().parseFromString(svg_string.text, "image/svg+xml");
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
					if(result.innerHTML !== svg){
						setSvg(result.innerHTML)
					}
				}
			}))
		).catch(err => console.error(err))
	}

	buildSvg();
	subscribe(() => {
		buildSvg();
	}, STORE_NAME);

	return (
		<div className="wapuu_show_room">
				<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" x="0" y="0" version="1.1" viewBox="10 120 1000 800"
						 dangerouslySetInnerHTML={{__html: svg}}></svg>
		</div>
	);
};
export default ShowRoom;
