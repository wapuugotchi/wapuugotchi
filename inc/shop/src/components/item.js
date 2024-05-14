import './item.scss';
import Pearl from './assets/pearl.svg';

import { useCallback } from '@wordpress/element';
import { dispatch, useSelect } from '@wordpress/data';

import { STORE_NAME } from '../store';

export default function Item( { uuid, item } ) {
	const { wapuu, balance, selectedCategory } = useSelect( ( select ) => {
		return {
			wapuu: select( STORE_NAME ).getWapuu(),
			balance: select( STORE_NAME ).getBalance(),
			selectedCategory: select( STORE_NAME ).getSelectedCategory(),
		};
	} );

	const handleItemClick = useCallback( () => {
		const avatarConfig = wapuu?.char?.[ selectedCategory ];
		if ( item.meta.price === 0 ) {
			const isItemSelected = avatarConfig?.key?.includes( uuid );
			const canDeselect = avatarConfig.key.length > avatarConfig.min;
			const canSelect = avatarConfig.key.length < avatarConfig.max;

			if ( isItemSelected && canDeselect ) {
				const index = avatarConfig.key.indexOf( uuid );
				avatarConfig.key.splice( index, 1 );
				dispatch( STORE_NAME ).setWapuu( wapuu );
			} else if ( ! isItemSelected && canSelect ) {
				avatarConfig.key.push( uuid );
				dispatch( STORE_NAME ).setWapuu( wapuu );
			} else if ( ! isItemSelected && ! canSelect ) {
				avatarConfig.key.pop();
				avatarConfig.key.push( uuid );
				dispatch( STORE_NAME ).setWapuu( wapuu );
			}
		} else if ( item.meta.price <= balance ) {
			dispatch( STORE_NAME ).showItemDetail( uuid );
		}
	}, [ balance, item, selectedCategory, uuid, wapuu ] );

	return (
		<div
			onClick={ handleItemClick }
			className={ `${
				wapuu?.char?.[ selectedCategory ]?.key?.includes( uuid )
					? 'wapuugotchi_shop__item selected'
					: 'wapuugotchi_shop__item'
			}${ item?.meta?.price === 0 ? ' free' : '' }` }
		>
			<img src={ item.preview } alt="Placeholder" />
			{ item?.meta?.price > 0 && (
				<div className="wapuugotchi_shop__price">
					<img src={ Pearl } />
					<span>{ item.meta.price }</span>
				</div>
			) }
		</div>
	);
}
