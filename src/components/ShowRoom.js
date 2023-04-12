import {cloneElement, createElement, useCallback, useState, useRef } from "@wordpress/element";
import { STORE_NAME, store } from "../store";
import { useSelect, subscribe } from '@wordpress/data';
import "./ShowRoom.css";
import "./Animation.css";

const getItemUrls = (wapuu, items, category) => {
	if(wapuu.char?.[category]?.key?.[0]) {
		return wapuu.char[category].key
			.filter(uuid => items[category][uuid])
			.map(uuid=>items[category][uuid].image)
		;
	}
	return [];
}

async function buildSvg(wapuu, items) {
		const responses = await Promise.all(
			Object.keys(wapuu.char)
				.map(category => getItemUrls(wapuu, items, category)
					.map(url => fetch(url)))
			.flat()
		);

		const svgs = (await Promise.all( responses.map(response=>response.text())))
			.map(_ => new DOMParser().parseFromString(_, "image/svg+xml"))
		;

		if(svgs.length) {
			const result = svgs.splice(svg => svg.querySelector('#wapuugotchi_svg__wapuu'), 1)[0]
				.querySelector('#wapuugotchi_svg__wapuu')
			;

			for (const svg of svgs) {
				Array.from(svg.querySelectorAll('g'))
					.filter(group => group.classList.value)
					.forEach(group => {
						const wapuu_svg_group = result.querySelector('g#' + group.classList.value);
						if(wapuu_svg_group) {
							group.removeAttribute('class');
							wapuu_svg_group.append(group);
						}
					})
				;
			}
			return result.innerHTML;
		}
}

function ShowRoom() {
	const { items, wapuu } = useSelect( select => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
		}
	});
	const [svg, setSvg] = useState([]);
	buildSvg(wapuu, items).then(setSvg);

	return (
		<div className="wapuu_show_room">
			{/*		changes to the ViewBox can destroy the animations.		*/}
			<svg xmlns="http://www.w3.org/2000/svg" x="0" y="0" version="1.1" viewBox="140 100 700 765"
					 dangerouslySetInnerHTML={{__html: svg}}></svg>
		</div>
	);
};
export default ShowRoom;
