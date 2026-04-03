import './items.scss';
import Item from './item';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';

export default function Items() {
	const { selectedCategory, items } = useSelect( ( select ) => {
		return {
			items: select( STORE_NAME ).getItems(),
			selectedCategory: select( STORE_NAME ).getSelectedCategory(),
		};
	} );

	const categoryItems = items?.[ selectedCategory ] ?? {};

	return (
		<div className="wapuugotchi_shop__items">
			{ Object.keys( categoryItems ).map( ( uuid, index ) => (
				<Item
					key={ uuid }
					uuid={ uuid }
					item={ categoryItems[ uuid ] }
					index={ index }
				/>
			) ) }
		</div>
	);
}
