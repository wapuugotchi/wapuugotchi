import './item.scss';
import Pearl from './assets/pearl.svg';

import {useCallback} from 'react';
import {dispatch, useSelect} from "@wordpress/data";

import {STORE_NAME} from "../store";
import PaymentDialog from "./payment-dialog";

export default function Item({uuid, item}) {
	const {wapuu, balance, selectedCategory, showItemDetail} = useSelect((select) => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			balance: select(STORE_NAME).getBalance(),
			selectedCategory: select(STORE_NAME).getSelectedCategory(),
			showItemDetail: select(STORE_NAME).getItemDetail(),
		};
	});

	const handleItemClick = useCallback(() => {
		console.log(uuid)
		const avatar_config = wapuu?.char?.[selectedCategory]
		if (item.meta.price === 0) {
			const isItemSelected = avatar_config?.key?.includes(uuid);
			const canDeselect = avatar_config.key.length > avatar_config.min;
			const canSelect = avatar_config.key.length < avatar_config.max;

			if (isItemSelected && canDeselect) {
				const index = avatar_config.key.indexOf(uuid);
				avatar_config.key.splice(index, 1);
				dispatch(STORE_NAME).setWapuu(wapuu);
			} else if (!isItemSelected && canSelect) {
				avatar_config.key.push(uuid);
				dispatch(STORE_NAME).setWapuu(wapuu);
			} else if (!isItemSelected && !canSelect) {
				avatar_config.key.pop();
				avatar_config.key.push(uuid);
				dispatch(STORE_NAME).setWapuu(wapuu);
			}
		} else {
			// Purchase item
			if (item.meta.price <= balance) {
				dispatch(STORE_NAME).showItemDetail(uuid);
			}

		}
	}, []);

	return (
		<div
			onClick={handleItemClick}
			className={
				wapuu?.char?.[selectedCategory]?.key?.includes(uuid)
					? 'wapuugotchi_shop__item selected'
					: 'wapuugotchi_shop__item'}>
			<img src={item.preview} alt="Placeholder"/>
			{item?.meta?.price > 0 && (
				<div className="wapuugotchi_shop__price">
					<img src={Pearl}/>
					<span>{item.meta.price}</span>
				</div>
			)}
		</div>
	);
}
