import Category from './category';
import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';

import './categories.scss';

export default function Categories() {
	const { categories } = useSelect( ( select ) => {
		return {
			categories: select( STORE_NAME ).getCategories(),
		};
	} );

	return (
		<div className="wapuugotchi_shop__categories">
			{ Object.keys( categories ).map( ( index ) => (
				<Category
					key={ index }
					slug={ index }
					meta={ categories[ index ] }
				/>
			) ) }
		</div>
	);
}
