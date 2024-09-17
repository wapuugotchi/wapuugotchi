import { getTextBox } from './boxUtils';
import { getClouds } from './cloudUtils';

/**
 * Erstellt ein SVG-Element basierend auf einem SVG-String.
 * @param {string} svgString - Der SVG-String.
 * @param {Object} quiz      - Das Quiz-Objekt.
 * @return {string} Das bearbeitete SVG als String.
 */
export const buildSvg = async ( svgString, quiz ) => {
	const parser = new DOMParser();
	const doc = parser.parseFromString( svgString, 'image/svg+xml' );
	const avatar = doc.querySelector( 'svg' );
	removeIgnoredElements( avatar );
	insertElement( avatar, getClouds( quiz.answers ), 'g#Front--group' );
	insertElement( avatar, getTextBox( quiz.question ), 'g#LeftArm--group' );

	return avatar.outerHTML;
};

export const insertElement = ( svg, element, tag ) => {
	const selectedElement = svg.querySelector(
		'g#wapuugotchi_type__wapuu, g#wapuugotchi_type__bear'
	);
	selectedElement?.insertBefore( element, svg.querySelector( tag ) );
};

export const removeIgnoredElements = ( svg ) => {
	const removeList = [
		'style',
		'g#Front--group g',
		'g#RightHand--group g',
		'g#BeforeRightHand--part g',
		'g#BeforeLeftArm--part g',
		'g#Ball--group',
	];
	removeList.forEach( ( selector ) => {
		svg.querySelectorAll( selector ).forEach( ( elem ) => elem.remove() );
	} );
};
