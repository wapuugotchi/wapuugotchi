import {createElement, useEffect, useState} from "@wordpress/element";
import { STORE_NAME, store } from "../store";
import { useSelect, dispatch } from '@wordpress/data';
import "./ShowRoom.css";

const ShowRoom = (props) => {
  const [svg, setSvg] = useState(null);
	const { items, categories, wapuu } = useSelect( select => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
			categories: select(STORE_NAME).getCategories(),
		}
	});

	console.log(wapuu)
  const onSvgCreationCompleted = (svg) => {
    setSvg(svg);
  };

	const get_image_list = () => {
		let result = [];
		Object.keys(props.wapuu.char).map((category) => {
			props.wapuu.char[category].key.map((WapuuItem) => {
				props.collection[category].map((CollectionItem) => {
					if (WapuuItem === CollectionItem.key) {
						result.push(CollectionItem);
					}
				});
			});
		});
		return result;
	};

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
	useEffect(() => {
		const furUrl = getItemUrls('fur')
		if(furUrl !== undefined) {
			//create list of all categories and remove fur. fur is the base svg of all other doings.
			let category_list = Object.keys(wapuu.char)
			category_list.splice(category_list.indexOf('fur'), 1)
			fetch(furUrl)
				.then((res) => res.text())
				.then((text) => {
					let fur = new DOMParser().parseFromString(text, "image/svg+xml");

					// loops the list of all categories to get all svg url.
					category_list.forEach(( category ) => {
						getItemUrls(category).forEach((url) => {
							console.log(url)
							fetch(url)
								.then((res) => res.text())
								.then((text) => {
									let svg = new DOMParser().parseFromString(text, "image/svg+xml");
									console.log(svg)
									let items = svg.querySelectorAll('g');
									if (items.length > 0) {
										items.forEach((item) => {
											let wapuu_svg_group = fur.querySelector('g#' + item.classList.value);
											if (wapuu_svg_group) {
												item.removeAttribute('class')
												wapuu_svg_group.append(item)
											}
										})
									}
									let result = fur.querySelector('svg').innerHTML.replace('xmlns="http://www.w3.org/2000/svg"', '')
									setSvg(result)
								});
						})
					});
				});
		}
	}, []);

	return (
		<div className="wapuu_show_room">
			{
				<svg xmlns="http://www.w3.org/2000/svg" id="Layer_1" x="0" y="0" version="1.1" viewBox="0 0 1000 1000"
					dangerouslySetInnerHTML={{__html: svg}}></svg>
			}
		</div>
	);
};
export default ShowRoom;
