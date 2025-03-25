import HideAndSeekSVG from '../../../assets/hide-and-seek.svg';
import { useEffect, useRef } from '@wordpress/element';
import { dispatch, useSelect } from '@wordpress/data';
import { STORE_NAME } from '../../store';
import apiFetch from '@wordpress/api-fetch';

const HEIGHT = 30;

/**
 * Decodes a base64 string.
 *
 * @param {string} base64 - The base64 string to decode.
 * @return {string} The decoded string.
 */
const decodeBase64 = ( base64 ) => {
	return decodeURIComponent(
		atob( base64 )
			.split( '' )
			.map( ( c ) => {
				return (
					'%' +
					( '00' + c.charCodeAt( 0 ).toString( 16 ) ).slice( -2 )
				);
			} )
			.join( '' )
	);
};

/**
 * Prepares the SVG string by parsing it into an SVG element and returning its inner HTML.
 *
 * @param {string} svgString - The SVG string to be parsed.
 * @return {string} The inner HTML of the parsed SVG element.
 */
const prepareSvg = ( svgString ) => {
	const base64Content = svgString.split( ',' )[ 1 ];
	const decodedString = decodeBase64( base64Content );
	const parser = new DOMParser();
	const doc = parser.parseFromString( decodedString, 'image/svg+xml' );
	return doc.querySelector( 'svg' ).innerHTML;
};

const positionSeekElement = ( selectors ) => {
	const validSelectors = selectors.filter( ( selector ) => {
		return document.querySelector( selector ) !== null;
	} );

	if ( validSelectors.length === 0 ) {
		return null;
	}

	const seekElement = document.getElementById( 'wapuugotchi__seek' );
	const selector =
		validSelectors[ Math.floor( Math.random() * validSelectors.length ) ];
	const element = document.querySelector( selector );
	if ( element && seekElement ) {
		const elementRect = element.getBoundingClientRect();
		seekElement.style.position = 'absolute';
		seekElement.style.top = `${
			elementRect.top - elementRect.height - HEIGHT - 1
		}px`;
		seekElement.style.left = `${ elementRect.left }px`;
		seekElement.style.width = `${ elementRect.width }px`;
		seekElement.style.height = `${ elementRect.height }px`;
	}

	return seekElement;
};

export default function Hidden() {
	const { data, nonces } = useSelect( ( select ) => ( {
		nonces: select( STORE_NAME ).getNonces(),
		data: select( STORE_NAME ).getData(),
	} ) );

	const hasPositioned = useRef( false );
	useEffect( () => {
		if ( ! data?.selectors || hasPositioned.current ) {
			return;
		}

		positionSeekElement( data.selectors );
		hasPositioned.current = true;

		const seekElement = document.querySelector( '#wapuugotchi__seek' );
		seekElement.addEventListener( 'click', async () => {
			// activate mission!!

			await apiFetch( {
				path: 'wapuugotchi/v1/hunt/complete_mission',
				method: 'POST',
				data: {
					id: data.id,
					nonce: nonces?.wapuugotchi_hunt,
				},
			} ).then( () => {
				dispatch( STORE_NAME ).setCompleted( true );
			} );
		} );
	}, [ data ] );

	return (
		<svg
			id="wapuugotchi_hunt__svg"
			xmlns="http://www.w3.org/2000/svg"
			height={ `${ HEIGHT }px` }
			width="100%"
			version="1.1"
			viewBox="0 0 26 14"
			dangerouslySetInnerHTML={ { __html: prepareSvg( HideAndSeekSVG ) } }
		></svg>
	);
}
