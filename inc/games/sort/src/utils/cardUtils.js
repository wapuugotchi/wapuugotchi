import { getTags, appendTagsToElement } from './textUtils';

// 3 cards: 2 top-row, 1 bottom-left (cards end at y=400, well above textbox at y=448).
export const CARD_POSITIONS = [
	{ x: 80, y: 200 },  // top-left
	{ x: 370, y: 200 }, // top-right
	{ x: 80, y: 310 },  // bottom-left
];

const CARD_W = 250;
const CARD_H = 90;
const CARD_CENTER_Y = CARD_H / 2; // 45

/**
 * Creates the SVG group containing all four draggable challenge cards.
 *
 * @param {string[]} items - The (shuffled) card label strings, including the distractor.
 * @return {Element} The card group element.
 */
export const getCards = ( items ) => {
	const cards = document.createElement( 'g' );
	cards.id = 'Card--group';

	items.forEach( ( item, index ) => {
		const card = document.createElement( 'g' );
		card.classList.add( 'card' );
		card.setAttribute( 'data-card-index', String( index ) );
		card.setAttribute(
			'transform',
			`translate(${ CARD_POSITIONS[ index ].x }, ${ CARD_POSITIONS[ index ].y })`
		);
		card.setAttribute( 'style', 'cursor: grab;' );

		const inner = document.createElement( 'g' );
		inner.classList.add( 'card-inner' );
		inner.style.animationDelay = `${ index * 0.12 }s`;
		inner.style.animationDuration = '1.5s';

		inner.innerHTML = cardSvg;

		const text = inner.querySelector( 'text' );
		const tags = getTags( item, 16 );
		// Shift start so all lines are vertically centred in the card.
		// font-size=28, dy=1.2em=33.6 SVG units → half-spacing = 16.8 ≈ 17.
		// Formula: center_y - (n+1) * half_spacing
		text.setAttribute( 'y', Math.round( CARD_CENTER_Y - ( tags.length + 1 ) * 17 ) );
		appendTagsToElement( text, tags, CARD_W / 2 );

		card.append( inner );
		cards.append( card );
	} );

	return cards;
};

// Note: explicit </rect> closing tag – the HTML parser does not support self-closing
// on unknown elements, which would nest <text> inside <rect> and hide it.
const cardSvg =
	`<rect x="0" y="0" width="${ CARD_W }" height="${ CARD_H }" rx="10" fill="white" stroke="#000" stroke-width="5"></rect>` +
	`<text xml:space="preserve" x="${ CARD_W / 2 }" y="${ CARD_CENTER_Y }" dominant-baseline="central" font-family="sans-serif" font-size="28" text-anchor="middle"></text>`;
