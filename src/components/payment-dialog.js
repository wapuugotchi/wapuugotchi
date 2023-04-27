import { STORE_NAME } from "../store";
import { useSelect, dispatch } from "@wordpress/data";
import { __experimentalConfirmDialog as ConfirmDialog } from '@wordpress/components';

import "./payment-dialog.scss"
import Category from "./category";

export default function PaymentDialog(props) {
	const { intention, } = useSelect((select) => {
		return {
			intention: select(STORE_NAME).getIntention(),
		};
	});

	const handlePayment = (item) => {
		dispatch(STORE_NAME).purchaseItem(item)
		dispatch(STORE_NAME).setIntention({})

	}
	return (
		<div >
			{Object.keys(intention).map((index) => (
					<div key={props.key} className="wapuu_payment__shadow_block">
						<ConfirmDialog
							key={props.key}
							className="wapuu_payment__confirm_dialog"
							onConfirm={ () => handlePayment(intention[index]) }
							onCancel={ () => dispatch(STORE_NAME).setIntention({}) }>
							<h2 className="wapuu_payment__item_name">{intention[index].meta.name}</h2>
							<div className="wapuu_payment__item_preview">
								<img src={intention[index].preview}/>
								<span className="wapuu_payment__info_icon dashicons dashicons-info" />
								<div className="wapuu_payment__item_tooltip">
									<div className="wapuu_payment__item_tooltip_shadow" />
									<p className="wapuu_payment__item_tooltip_text">{intention[index].meta.description}</p>
									<p className="wapuu_payment__item_tooltip_author">Author: {intention[index].meta.author}</p>
								</div>
							</div>
							<p className="wapuu_payment__confirm_text">Do you want to buy this item?</p>
						</ConfirmDialog>
					</div>
			))}
		</div>
	)
}
