import { useState } from "@wordpress/element";
import "./shop.scss";
import Card from "./card";
import apiFetch from "@wordpress/api-fetch";
import ShowRoom from "./show-room";
import { STORE_NAME } from "../store";
import { useSelect, dispatch } from "@wordpress/data";

import priceTag from "./category-item-pricetag.svg";

export default function Shop(props) {
	let { wapuu, balance, restBase } = useSelect((select) => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
			categories: select(STORE_NAME).getCategories(),
			balance: select(STORE_NAME).getBalance(),
			restBase: select(STORE_NAME).getRestBase(),
		};
	});

	const [name, setName] = useState(wapuu.name);
	const [loader, setLoader] = useState("Save");

	const resetHandler = async () => {
		const wapuu_data = await apiFetch({ path: `${restBase}/wapuu` });
		dispatch(STORE_NAME).setWapuu(wapuu_data);
		setName(wapuu_data.name);
	};

	const submitHandler = async (event) => {
		event.preventDefault();
		setLoader("Saving...");
		wapuu.name = name;

		const success = await apiFetch({
			path: `${restBase}/wapuu`,
			method: "POST",
			data: { wapuu },
		});

		setLoader("Save Settings");
	};

	return (
		<div className="wapuu_shop">
			<div className="wapuu_shop__header">
				<h1 className="wapuu_shop__title">
					Customize Your Wapuu with WapuuGotchi
				</h1>
				{/*<span className="wapuu_shop__divider" />*/}
				<p className="wapuu_shop__description">
					Browse categories on the left to explore various items and style your
					Wapuu.
				</p>
				<span className="wapuu_shop__pearls">
					Your Pearl Balance:
					<img alt="" src={priceTag} />
					{ balance }
				</span>
			</div>
			<form onSubmit={submitHandler}>
				<Card key="settings-card" />
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
							Reset Changes
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
