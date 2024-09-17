import { appendTagsToElement } from './textUtils';

const x = 155;
const y = 250;

// Other SVG-related functions...
export const getTextBox = ( agreement ) => {
	const textBoxTags = agreement;
	const element = document.createElement( 'g' );
	element.id = 'TextBox--group';
	element.innerHTML = boxSvg;

	appendTagsToElement( element.querySelector( 'text' ), textBoxTags, x );

	return element;
};

const boxSvg = `
<path fill="#fff" stroke="#000" stroke-width="5" d="M80 448.211h500v300H80z"></path>
<text text-anchor="middle" x="${ x }" y="${ y }" font-family="sans-serif" font-size="14" style="line-height:1.25" transform="scale(2)"></text>
`;
