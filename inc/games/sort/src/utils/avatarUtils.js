import { getTextBox } from './boxUtils';
import { getCards } from './cardUtils';
import { getSlots } from './slotUtils';

/**
 * Builds the complete avatar SVG for a sort challenge.
 *
 * All three elements are inserted before g#LeftArm--group so the arm
 * renders on top of them (preserving the "Wapuu holds the box" effect).
 * Insertion order matters: textBox first → slots → cards last (= on top).
 *
 * @param {string} svgString - The base avatar SVG string.
 * @param {Object} sort      - The sort challenge data object.
 * @return {string} The modified SVG as an outer HTML string.
 */
export const buildSvg = async ( svgString, sort ) => {
	const parser = new DOMParser();
	const doc = parser.parseFromString( svgString, 'image/svg+xml' );
	const avatar = doc.querySelector( 'svg' );
	removeIgnoredElements( avatar );

	insertElement( avatar, getTextBox( sort.question ), 'g#LeftArm--group' );
	insertElement( avatar, getSlots(), 'g#LeftArm--group' );
	insertElement( avatar, getCards( sort.items ), 'g#LeftArm--group' );

	return avatar.outerHTML;
};

export const insertElement = ( svg, element, tag ) => {
	const selectedElement = svg.querySelector(
		'g#wapuugotchi_type__wapuu, g#wapuugotchi_type__bear, g#wapuugotchi_type__rabbit, g#wapuugotchi_type__squirrel'
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
