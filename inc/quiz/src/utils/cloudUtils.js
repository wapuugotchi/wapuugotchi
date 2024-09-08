import { getTags, appendTagsToElement } from './textUtils';

const position = [
	{ x: 0, y: 0 },
	{ x: 320, y: 140 },
	{ x: -340, y: 140 },
];
export const getClouds = ( answers ) => {
	const clouds = document.createElement( 'g' );
	clouds.id = 'Cloud--group';

	const yPosition = 56;

	answers.forEach( ( answer, index ) => {
		const cloud = document.createElement( 'g' );
		cloud.classList.add( 'cloud' );
		cloud.setAttribute(
			'transform',
			`translate(${ position[ index ].x }, ${ position[ index ].y })`
		);
		cloud.innerHTML = cloudSvg;

		const text = cloud.querySelector( 'text' );
		const tags = getTags( answer, 20 );
		text.setAttribute( 'y', yPosition - tags.length * 8 );
		const x = parseInt( text.getAttribute( 'x' ) ) || 0;
		appendTagsToElement( text, tags, x );

		clouds.append( cloud );
	} );

	return clouds;
};

const cloudSvg = `
<path stroke="#000" stroke-width="5" fill="white" fill-rule="evenodd" d="M548.202 44.408a66.593 66.593 0 0 0-52.8 26.283 66.593 66.593 0 0 0-25.598-5.117 66.593 66.593 0 0 0-53.013 26.56 66.593 66.593 0 0 0-1.425-.035 66.593 66.593 0 0 0-66.59 66.593 66.593 66.593 0 0 0 66.588 66.588 66.593 66.593 0 0 0 2.941-.21 106.118 66.593 0 0 0 84.071 25.967 106.118 66.593 0 0 0 86.435-28.167 66.593 66.593 0 0 0 17.436 2.41 66.593 66.593 0 0 0 66.588-66.588 66.593 66.593 0 0 0-60.715-66.319 66.593 66.593 0 0 0-63.918-47.965z"></path>
<text xml:space="preserve" x="78" y="45" font-family="sans-serif" font-size="12" style="line-height:1.25;text-align:center;white-space:pre;inline-size:111.164" text-anchor="middle" transform="translate(348.776 44.408) scale(2)"></text>`;
