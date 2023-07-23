import Category from './category';
import CategoryItems from './category-items';

import { useCallback, useState } from '@wordpress/element';
import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';

import './categories.scss';

export default function Categories() {
	const [ selectedCategory, setSelectedCategory ] = useState( 'fur' );
	const { items, categories, wapuu } = useSelect( ( select ) => {
		return {
			wapuu: select( STORE_NAME ).getWapuu(),
			items: select( STORE_NAME ).getItems(),
			categories: select( STORE_NAME ).getCategories(),
		};
	} );

	const __getItemList = () => {
		let itemList = [];

		if ( items[ selectedCategory ] !== undefined ) {
			itemList = Object.values( items[ selectedCategory ] ).map(
				( item ) => {
					const classes = [ 'wapuu_card__item' ];
					if (
						wapuu.char?.[ selectedCategory ]?.key?.includes(
							item.meta.key
						)
					) {
						classes.push( ' selected' );
					} else if ( item.meta.price > 0 ) {
						classes.push( 'wapuu_card__locked' );
					}

					let tooltip;
					if ( item.meta.price > 0 ) {
						tooltip = item.meta.price;
					}

					return {
						...item,
						classes: classes.join( ' ' ),
						tooltip,
					};
				}
			);
		}

		// show locked items at the end
		itemList.sort( ( a, b ) => a.meta.price - b.meta.price );

		return itemList;
	};

	// getItemList is a cached version of __getItemLisst only changing when items or selectedCategory changed
	const getItemList = useCallback( __getItemList, [
		items,
		selectedCategory,
		wapuu,
	] );

	return (
		<>
			<div className="wapuu_card__categories">
				{ Object.keys( categories ).map( ( index ) => (
					<Category
						key={ index }
						slug={ index }
						category={ categories[ index ] }
						setSelectedCategory={ setSelectedCategory }
						selectedCategory={ selectedCategory }
					/>
				) ) }
			</div>
			<CategoryItems
				getItemList={ getItemList }
				selectedCategory={ selectedCategory }
			/>
		</>
	);
}
