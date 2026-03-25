const SLOT_W = 250;
const SLOT_H = 90;

// Slots are stacked vertically, centred in the 500 px wide box (x=80–580).
// They sit below the question text which ends around y≈634 with 4 lines.
export const SLOT_POSITIONS = [
	{ x: 205, y: 650 },
	{ x: 205, y: 750 },
	{ x: 205, y: 850 },
];

/**
 * Creates the SVG group containing three numbered vertical drop slot placeholders.
 *
 * @return {Element} The slot group element.
 */
export const getSlots = () => {
	const group = document.createElement( 'g' );
	group.id = 'Slot--group';

	SLOT_POSITIONS.forEach( ( pos, i ) => {
		const slot = document.createElement( 'g' );
		slot.setAttribute( 'transform', `translate(${ pos.x }, ${ pos.y })` );
		slot.innerHTML = getSlotSvg( i + 1 );
		group.append( slot );
	} );

	return group;
};

/**
 * Returns the inner SVG markup for a single numbered slot.
 *
 * @param {number} num - The slot number to display (1, 2, or 3).
 * @return {string} SVG markup string.
 */
// Note: explicit closing tags prevent the HTML parser from nesting elements
// inside <rect> or <circle>, which would break SVG rendering.
const getSlotSvg = ( num ) =>
	`<rect width="${ SLOT_W }" height="${ SLOT_H }" rx="8" fill="#f0f0f0" stroke="#aaa" stroke-width="3" stroke-dasharray="8,4"></rect>` +
	`<circle cx="${ SLOT_W - 20 }" cy="15" r="13" fill="#555"></circle>` +
	`<text x="${
		SLOT_W - 20
	}" y="15" text-anchor="middle" dominant-baseline="middle" fill="white" font-size="15" font-family="sans-serif">${ num }</text>`;
