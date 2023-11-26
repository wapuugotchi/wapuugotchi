import { useCallback } from '@wordpress/element';

import { STORE_NAME } from '../../store/wapuu';
import { useSelect, dispatch } from '@wordpress/data';

import priceTag from './category-item-pricetag.svg';
import './category-item.scss';

export default function CategoryItem( { selectedCategory, item } ) {
	const { items, wapuu, balance } = useSelect( ( select ) => {
		return {
			wapuu: select( STORE_NAME ).getWapuu(),
			items: select( STORE_NAME ).getItems(),
			categories: select( STORE_NAME ).getCategories(),
			balance: select( STORE_NAME ).getBalance(),
		};
	} );

	const __handleItem = () => {
		const dataKey = item.meta.key;

		if (
			items[ selectedCategory ] &&
			items[ selectedCategory ][ dataKey ]
		) {
			const itemData = items[ selectedCategory ][ dataKey ];
			if ( itemData.meta?.price > 0 ) {
				if ( itemData.meta.price <= balance ) {
					dispatch( STORE_NAME ).setIntention( { item } );
				}
			} else {
				const categoryData = wapuu.char[ selectedCategory ];
				if ( categoryData ) {
					if ( categoryData.key.includes( dataKey ) ) {
						if ( ! categoryData.required ) {
							const index = categoryData.key.indexOf( dataKey );
							categoryData.key.splice( index, 1 );
							dispatch( STORE_NAME ).setWapuu( wapuu );
						}
					} else {
						if (
							categoryData.count <
							categoryData.key.length + 1
						) {
							categoryData.key.pop();
						}
						categoryData.key.push( dataKey );
						dispatch( STORE_NAME ).setWapuu( wapuu );
					}
				}
			}
		}
	};

	// create a cached version of handleItem updated only when selectedCategory or item changes
	const handleItem = useCallback( __handleItem, [
		selectedCategory,
		item,
		balance,
		items,
		wapuu,
	] );

	return (
		<>
			{  }
			<div onClick={ handleItem } className={ item.classes }>
				<img className="wapuu_card__item_img" src={ item.preview } />
				{ item.tooltip && (
					<div className="wapuu_card__item_pricetag">
						<img src={ priceTag } />
						<span>{ item.tooltip }</span>
					</div>
				) }
			</div>
		</>
	);
}
