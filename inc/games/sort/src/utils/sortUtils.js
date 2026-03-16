import { getTags } from './textUtils';

/**
 * Extracts and formats the first sort element from the data list.
 * @param {Array} list - The list of sort challenges.
 * @return {Object} The formatted sort element for rendering.
 */
export const getSortElement = ( list ) => {
	const item = list[ 0 ];
	return {
		question: getTags( item.question, 25 ),
		agreement: getTags( item.correct_notice, 25 ),
		disagreement: getTags( item.incorrect_notice, 25 ),
		items: item.items,
		correct_order: item.correct_order,
	};
};
