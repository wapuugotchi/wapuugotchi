import { appendTagsToElement } from './textUtils';

const x = 165;
const y = 250;

export const TEXT_CENTER_X = x;

export const getTextBox = ( question ) => {
	const element = document.createElement( 'g' );
	element.id = 'TextBox--group';
	element.innerHTML = boxSvg;

	appendTagsToElement( element.querySelector( 'text' ), question, x );

	return element;
};

// Extended height (300 → 500) to accommodate three vertical drop slots (90 px each) below the question text.
const boxSvg = `
<path fill="#fff" stroke="#000" stroke-width="5" d="M80 448.211h500v515H80z"></path>
<text text-anchor="middle" x="${ x }" y="${ y }" font-family="sans-serif" font-size="14" style="line-height:1.25" transform="scale(2)"></text>
`;
