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
							className="wapuu_payment__confirm_dialog"
							onConfirm={ () => handlePayment(intention[index]) }
							onCancel={ () => dispatch(STORE_NAME).setIntention({}) }>
							<p>Do you want to buy this item?</p>
							<img className="wapuu_payment__item_preview" src={intention[index].preview}/>
						</ConfirmDialog>
					</div>
			))}
		</div>
	)
}
