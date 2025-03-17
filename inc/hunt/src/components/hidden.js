import { useEffect, useRef } from 'react';
import HideAndSeekSVG from "../../assets/hide-and-seek.svg";
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import './hidden.scss';

const HEIGHT = 30;
/**
 * Decodes a base64 string.
 *
 * @param {string} base64 - The base64 string to decode.
 * @return {string} The decoded string.
 */
const decodeBase64 = (base64) => {
	return decodeURIComponent(atob(base64).split('').map((c) => {
		return '%' + ('00' + c.charCodeAt(0).toString(16)).slice(-2);
	}).join(''));
};

/**
 * Prepares the SVG string by parsing it into an SVG element and returning its inner HTML.
 *
 * @param {string} svgString - The SVG string to be parsed.
 * @return {string} The inner HTML of the parsed SVG element.
 */
const prepareSvg = (svgString) => {
	const base64Content = svgString.split(',')[1];
	const decodedString = decodeBase64(base64Content);
	const parser = new DOMParser();
	const doc = parser.parseFromString(decodedString, 'image/svg+xml');
	return doc.querySelector('svg').innerHTML;
};

const positionSeekElement = (selectors) => {
	let validSelectors = selectors.filter(selector => {
		return document.querySelector(selector) !== null;
	});

	if (validSelectors.length === 0) {
		return null;
	}

	const seekElement = document.getElementById('wapuugotchi__seek');
	const selector = validSelectors[Math.floor(Math.random() * validSelectors.length)];
	const element = document.querySelector(selector);
	if (element && seekElement) {
		const elementRect = element.getBoundingClientRect();
		seekElement.style.position = 'absolute';
		seekElement.style.top = `${elementRect.top - elementRect.height - HEIGHT - 1}px`;
		seekElement.style.left = `${elementRect.left}px`;
		seekElement.style.width = `${elementRect.width}px`;
		seekElement.style.height = `${elementRect.height}px`;
	}

	return seekElement;
};

export default function Hidden() {
	const { data, avatar } = useSelect((select) => ({
		data: select(STORE_NAME).getData(),
		avatar: select(STORE_NAME).getAvatar(),
	}));

	const hasPositioned = useRef(false);

	useEffect(() => {
		const executeSeek = ( event ) => {
			//entferne das svg dass das seek element versteckt und füge staddessen das avatar svg hinzu
			event.target.querySelector('svg').remove();
			event.target.innerHTML = avatar;
			event.target.style.position = 'absolute';
			event.target.style.top = '50%';
			event.target.style.left = '50%';
			event.target.style.transform = 'translate(-50%, -50%)';
			event.target.style.width = '400px';
			event.target.style.height = '400px';
			event.target.classList.add('fade-out');

			setTimeout(() => {
				event.target.removeEventListener('click', executeSeek);
				event.target.remove();
			}, 4000);

			//entferne den event listener


		};

		if (data?.selectors && !hasPositioned.current) {
			positionSeekElement(data.selectors);
			hasPositioned.current = true;

			const seekElement = document.getElementById('wapuugotchi__seek');
			seekElement.addEventListener('click', executeSeek);
		}
	}, [data]);

	return (
		<svg
			id="wapuugotchi_hunt__svg"
			xmlns="http://www.w3.org/2000/svg"
			height={`${HEIGHT}px`}
			width="100%"
			version="1.1"
			viewBox="0 0 26 14"
			dangerouslySetInnerHTML={{ __html: prepareSvg(HideAndSeekSVG) }}
		></svg>
	);
}
