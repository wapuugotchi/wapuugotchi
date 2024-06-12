import { STORE_NAME } from '../store';
import { useDispatch, useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { __experimentalConfirmDialog as ConfirmDialog } from '@wordpress/components';
import { useCallback } from '@wordpress/element';

import './payment-dialog.scss';

export default function PaymentDialog() {
	const { itemDetail, items, selectedCategory } = useSelect( ( select ) => {
		return {
			itemDetail: select( STORE_NAME ).getItemDetail(),
			selectedCategory: select( STORE_NAME ).getSelectedCategory(),
			items: select( STORE_NAME ).getItems(),
		};
	} );

	const { showItemDetail, purchaseItem } = useDispatch( STORE_NAME );
	const item = items?.[ selectedCategory ]?.[ itemDetail ];

	const handleConfirm = useCallback( () => {
		purchaseItem( item );
		showItemDetail( null );
	}, [ purchaseItem, showItemDetail, item ] );

	const handleCancel = useCallback( () => {
		showItemDetail( null );
	}, [ showItemDetail ] );

	return (
		<>
			{ itemDetail !== null && item?.meta !== undefined && (
				<div className="wapuugotchi_shop__overlay">
					<ConfirmDialog
						className="wapuu_payment__confirm_dialog"
						onConfirm={ handleConfirm }
						onCancel={ handleCancel }
					>
						<h2 className="wapuu_payment__item_name">
							{ item?.meta?.name }
						</h2>
						<div className="wapuu_payment__item_preview">
							<img src={ item?.preview } />
							<span className="wapuu_payment__info_icon dashicons dashicons-info" />
							<div className="wapuu_payment__item_tooltip">
								<div className="wapuu_payment__item_tooltip_shadow" />
								<p className="wapuu_payment__item_tooltip_text">
									{ item?.meta?.description }
								</p>
								<p className="wapuu_payment__item_tooltip_author">
									Discoverer: { item?.meta?.author }
								</p>
							</div>
						</div>
						<p className="wapuu_payment__confirm_text">
							{ __(
								'Do you want to buy this item?',
								'wapuugotchi'
							) }
						</p>
					</ConfirmDialog>
				</div>
			) }
		</>
	);
}
