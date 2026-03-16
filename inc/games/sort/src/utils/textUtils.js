export const getTags = ( sentence, length ) => {
	const tags = [];
	let tag = '';
	const words = sentence.split( ' ' );

	words.forEach( ( word ) => {
		if ( tag.length + word.length > length ) {
			tags.push( tag );
			tag = word;
		} else {
			tag += ' ' + word;
		}
	} );

	tags.push( tag );
	return tags;
};

export const appendTagsToElement = ( element, tags, x ) => {
	tags.forEach( ( tag ) => {
		const tspan = createTspan( tag, x );
		element.appendChild( tspan );
	} );
};

/**
 * Create a TSPAN element with given tag, x and y attributes.
 *
 * @param {string} tag - The text content of the TSPAN element.
 * @param {number} x   - The x attribute of the TSPAN element.
 * @return {Object} The created TSPAN element.
 */
const createTspan = ( tag, x ) => {
	const tspan = document.createElementNS(
		'http://www.w3.org/2000/svg',
		'tspan'
	);
	tspan.textContent = tag;
	tspan.setAttribute( 'x', x );
	tspan.setAttribute( 'dy', '1.2em' );
	return tspan;
};
