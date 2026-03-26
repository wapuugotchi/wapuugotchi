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
			{ item?.meta?.colored === 1 && (
				<span className="wapuugotchi_shop__colored_hint">
					<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" aria-hidden="true" focusable="false">
						<path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c.89 0 1.75-.13 2.59-.37.58-.17.94-.76.77-1.34-.18-.59-.78-.94-1.38-.77-.63.18-1.29.27-1.98.27-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8c0 1.1-.89 2-2 2s-2-.9-2-2c0-1.1-.9-2-2-2s-2 .9-2 2c0 2.21 1.79 4 4 4 .73 0 1.41-.21 2-.57C19.41 19.27 22 15.97 22 12c0-5.51-4.49-10-10-10zM7 13c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2-4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2 4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" />
					</svg>
				</span>
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
