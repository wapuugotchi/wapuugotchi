import { useState } from "@wordpress/element";
import "./Shop.css";
import Card from "./Card";
import apiFetch from "@wordpress/api-fetch";
import ShowRoom from "./ShowRoom";
import { STORE_NAME } from "../store";
import { useSelect } from '@wordpress/data';

const Shop = (props) => {
	const { wapuu, items, categories, restBase } = useSelect( select => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
			categories: select(STORE_NAME).getCategories(),
			restBase: select(STORE_NAME).getRestBase(),
		};
	});

	const [name, setName] = useState(wapuu.name);
	const [loader, setLoader] = useState("Save");

	const nameHandler = (event) => {
		setName(event.target.value);
	};

	const wapuuHandler = (wapuuConfig) => {
		props.onChangeWapuuConfig(wapuuConfig);
	};

	const resetHandler = async () => {
		wapuuHandler({
			...await apiFetch({ path: `${restBase}/wapuu` }),
			name
		});
	};

	const submitHandler = async (event) => {
		event.preventDefault();
		setLoader("Saving...");
		wapuu.name = name;

		const success = await apiFetch({
			path: `${restBase}/wapuu`,
			method: 'POST',
			data: { wapuu },
		});

		setLoader("Save Settings");
	};

	return (
		<div className="wapuu_shop">
			<div className="wapuu_shop__header">
				<h1 className="wapuu_shop__title">Customize Your Wapuu with WapuuGotchi</h1>
				{/*<span className="wapuu_shop__divider" />*/}
				<p className="wapuu_shop__description">
					Browse categories on the left to explore various items and style your Wapuu.
				</p>
				<span className="wapuu_shop__pearls">
					Your Pearl Balance:
					<img alt="" src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTciIGhlaWdodD0iMTIiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgZmlsbD0ibm9uZSIgdmlld0JveD0iMCAwIDE3IDEyIj4KCTxwYXRoIGZpbGw9IiNmZmYiIGQ9Ik04Ljg5NiA0LjI0YTMuODg4IDMuODg4IDAgMCAwLTMuODggMy44OEEzLjg4OCAzLjg4OCAwIDAgMCA4Ljg5NiAxMmEzLjg4OCAzLjg4OCAwIDAgMCAzLjg4LTMuODggMy44ODkgMy44ODkgMCAwIDAtMy44OC0zLjg4Wm0xLjg0NyA0LjQxYy0uMjkgMC0uNTMtLjI0LS41My0uNTNhMS4zMyAxLjMzIDAgMCAwLTEuMzE3LTEuMzE3LjUzMy41MzMgMCAwIDEtLjUzLS41M2MwLS4yOS4yNC0uNTMuNTMtLjUzYTIuNCAyLjQgMCAwIDEgMi4zOTQgMi4zOTRjMCAuMjczLS4yNC41MTMtLjU0Ny41MTNaTTYuMjQ3IDMuMTExYy4wODUuMjA1LjI5LjMyNS40OTYuMzI1YS44NTQuODU0IDAgMCAwIC4yMDUtLjAzNC41MzQuNTM0IDAgMCAwIC4yOS0uNzAxTDYuNzI1IDEuNDdhLjU0OC41NDggMCAwIDAtLjctLjI5LjUzNC41MzQgMCAwIDAtLjI5MS43bC41MTMgMS4yMzFabS0uOTU3LjYzM0wzLjkyMiAyLjM3NmEuNTM3LjUzNyAwIDAgMC0uNzUyIDAgLjUzNy41MzcgMCAwIDAgMCAuNzUybDEuMzY3IDEuMzY4YS41My41MyAwIDAgMCAuMzc3LjE1NC41My41MyAwIDAgMCAuMzc2LS4xNTQuNTM3LjUzNyAwIDAgMCAwLS43NTJaTTMuODg4IDUuNDdsLTEuMjMtLjUxM2EuNTM0LjUzNCAwIDAgMC0uNzAyLjI5LjUzNC41MzQgMCAwIDAgLjI5LjcwMmwxLjIzMi41MTJhLjQzMy40MzMgMCAwIDAgLjIwNS4wMzVjLjIwNSAwIC40MS0uMTIuNDk1LS4zMjUuMTAzLS4yNzQtLjAxNy0uNTk4LS4yOS0uNzAxWm0tLjEwMyAyLjY1YS41MzIuNTMyIDAgMCAwLS41My0uNTNIMS4zMDdjLS4yOSAwLS41My4yMzktLjUzLjUzIDAgLjI5LjI0LjUzLjUzLjUzaDEuOTQ4Yy4yOTEgMCAuNTMtLjI0LjUzLS41M1ptLS4zMDcgMS42NzUtMS4yMzEuNTEzYS41MzQuNTM0IDAgMCAwLS4yOS43Yy4wODUuMjA2LjI5LjMyNS40OTUuMzI1YS44NTIuODUyIDAgMCAwIC4yMDUtLjAzNGwxLjIzLS41MTNhLjUzNC41MzQgMCAwIDAgLjI5MS0uNy41MzMuNTMzIDAgMCAwLS43LS4yOTFabTEyLjA2OC40OTUtMS4yMy0uNTEyYS41MzQuNTM0IDAgMCAwLS43MDIuMjkuNTM0LjUzNCAwIDAgMCAuMjkxLjcwMWwxLjIzLjUxM2EuNDMyLjQzMiAwIDAgMCAuMjA2LjAzNGMuMjA1IDAgLjQxLS4xMi40OTUtLjMyNWEuNTQ4LjU0OCAwIDAgMC0uMjktLjdabS45NC0yLjdoLTEuOTQ4Yy0uMjkgMC0uNTMuMjQtLjUzLjUzIDAgLjI5LjI0LjUzLjUzLjUzaDEuOTMxYy4yOSAwIC41My0uMjQuNTMtLjUzYS41MDguNTA4IDAgMCAwLS41MTMtLjUzWm0tMi44NzItMS40MTlhLjU0LjU0IDAgMCAwIC40OTYuMzI1Ljg1NS44NTUgMCAwIDAgLjIwNS0uMDM0bDEuMjMxLS41MTNhLjUzNC41MzQgMCAwIDAgLjI5LS43MDEuNTQ4LjU0OCAwIDAgMC0uNy0uMjlsLTEuMjMxLjUxMmMtLjI3My4xMDMtLjM5My40MjctLjI5LjcwMVptMS4wMjYtMy43OTVhLjUzNy41MzcgMCAwIDAtLjc1MiAwTDEyLjUyIDMuNzQ0YS41MzcuNTM3IDAgMCAwIDAgLjc1Mi41My41MyAwIDAgMCAuMzc2LjE1NC41My41MyAwIDAgMCAuMzc2LS4xNTRsMS4zNjgtMS4zNjhhLjUzNy41MzcgMCAwIDAgMC0uNzUyWm0tMy43OTUgMS4wMjZhLjQzMy40MzMgMCAwIDAgLjIwNS4wMzQuNTQuNTQgMCAwIDAgLjQ5Ni0uMzI1bC41MTMtMS4yM2EuNTM0LjUzNCAwIDAgMC0uMjktLjcwMS41MzQuNTM0IDAgMCAwLS43MDIuMjlsLS41MTMgMS4yM2EuNTQ5LjU0OSAwIDAgMCAuMjkxLjcwMlptLTEuOTQ4LS4zOTNjLjI5IDAgLjUzLS4yNC41My0uNTNWLjUyOWMwLS4yOS0uMjQtLjUyOS0uNTMtLjUyOS0uMjkxIDAtLjUzLjI0LS41My41M3YxLjkzMmMwIC4zMDcuMjM5LjU0Ni41My41NDZaIi8+Cjwvc3ZnPgo=" />
					150
				</span>
			</div>
			<form onSubmit={submitHandler}>
				<Card
					key="settings-card"
					onChangeWapuuConfig={wapuuHandler}
				/>
				<div className="wapuu_shop__items">
					<div className="wapuu_shop__input">
						<input
							className="wapuu_shop__name"
							type="text"
							value={name}
							onChange={nameHandler}
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
};

export default Shop;
