import { useState } from "@wordpress/element";
import { useSelect, dispatch } from "@wordpress/data";
import apiFetch from "@wordpress/api-fetch";
import { __ } from '@wordpress/i18n';
import { STORE_NAME } from "../store";
import Card from "./card";
import ShowRoom from "./show-room";
import PaymentDialog from "./payment-dialog";
import MenuHeader from "./menu-header";
import "./shop.scss";


export default function Shop(props) {
	let { wapuu, balance, intention, restBase } = useSelect((select) => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
			categories: select(STORE_NAME).getCategories(),
			balance: select(STORE_NAME).getBalance(),
			intention: select(STORE_NAME).getIntention(),
			restBase: select(STORE_NAME).getRestBase(),
		};
	});

	const [name, setName] = useState(wapuu.name);
	const [loader, setLoader] = useState(__('Save', 'wapuugotchi'));

	const resetHandler = async () => {
		const wapuu_data = await apiFetch({ path: `${restBase}/wapuu` });
		dispatch(STORE_NAME).setWapuu(wapuu_data);
		setName(wapuu_data.name);
	};

	const submitHandler = async (event) => {
		event.preventDefault();
		setLoader(__('Saving...', 'wapuugotchi'));
		wapuu.name = name;

		const success = await apiFetch({
			path: `${restBase}/wapuu`,
			method: "POST",
			data: { wapuu },
		});

		console.log('saved ' + success);

		setLoader(__("Save Settings",'wapuugotchi'));
	};

	return (
		<div className="wapuu_shop">
			<MenuHeader
				title={__('Customize Your Wapuu with WapuuGotchi', 'wapuugotchi')}
				description={__('Browse categories on the left to explore various items and style your Wapuu.', 'wapuugotchi')}
			/>
			<form onSubmit={submitHandler}>
				<Card key="settings-card" />
				<PaymentDialog key="payment-dialog"/>
				<div className="wapuu_shop__items">
					<div className="wapuu_shop__input">
						<input
							className="wapuu_shop__name"
							type="text"
							value={name}
							onChange={(e) => setName(e.target.value)}
						/>
					</div>
					<div className="wapuu_shop__image">
						<div className="wapuu_shop__img">
							<ShowRoom />
						</div>
					</div>
					<div className="wapuu_shop__button">
						<button
							onClick={resetHandler}
							className="button button-secondary wapuu_shop__reset"
							type="button"
						>
							{__('Reset Changes', 'wapuugotchi')}
						</button>
						<button
							className="button button-primary wapuu_shop__submit"
							type="submit"
						>
							{loader}
						</button>
					</div>
				</div>
			</form>
		</div>
	);
}
