import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import HideAndSeekSVG from '../assets/hide-and-seek.svg';

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


const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi__seek' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi__avatar';
		document.getElementById( 'wpbody' ).append( domElement );

		domElement = positionSeekElement( domElement);
	}
	return domElement;
};

const positionSeekElement = ( seekElement ) => {
	console.log('Positioning seek element');
	const catElement = document.getElementById('doaction2');
	if (catElement) {
		console.log('catElement');
	}
	if (seekElement) {
		console.log('seekElement');
	}


	if (catElement && seekElement) {
		console.log('Positioning seek element 2');
		const catRect = catElement.getBoundingClientRect();
		console.log(catRect);
		seekElement.style.position = 'fixed';
		seekElement.style.top = `${catRect.top - catRect.height}px`;
		seekElement.style.left = `${catRect.left}px`;
		seekElement.style.width = `${catRect.width}px`;
		seekElement.style.height = `${catRect.height}px`;
	}

	return seekElement;
};

domReady(() => {
	const domElement = getDomElement();
	createRoot(domElement).render(
		<StrictMode>
			<svg
				id="wapuugotchi_hunt__svg"
				xmlns="http://www.w3.org/2000/svg"
				height="100%"
				width="100%"
				version="1.1"
				viewBox="0 0 26 14"
				dangerouslySetInnerHTML={{ __html: prepareSvg(HideAndSeekSVG) }}
			></svg>
		</StrictMode>
	);
});
