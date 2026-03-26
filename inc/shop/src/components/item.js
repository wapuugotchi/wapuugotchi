import './item.scss';
import Pearl from './assets/pearl_black.svg';

import { useCallback } from '@wordpress/element';
import { dispatch, useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';

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

	const isSelected = wapuu?.char?.[ selectedCategory ]?.key?.includes( uuid );
	const canAfford = item?.meta?.price <= balance;

	return (
		<div
			onClick={ handleItemClick }
			className={ `${
				isSelected
					? 'wapuugotchi_shop__item selected'
					: 'wapuugotchi_shop__item'
			}${ item?.meta?.price === 0 ? ' free' : '' }` }
		>
			<img src={ item.preview } alt="" />
			{ isSelected && (
				<div className="wapuugotchi_shop__owned_badge">
					{ __( 'Ausgewählt', 'wapuugotchi' ) }
				</div>
			) }
			{ item?.meta?.price > 0 && (
				<div
					className={ `wapuugotchi_shop__pill ${
						canAfford
							? 'wapuugotchi_shop__pill--success'
							: 'wapuugotchi_shop__pill--muted'
					}` }
				>
					<img
						className="wapuugotchi_shop__pearl-icon"
						src={ Pearl }
						alt=""
					/>
					<span>{ item.meta.price }</span>
				</div>
			) }
		</div>
	);
}
