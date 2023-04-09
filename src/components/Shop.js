import { useState } from "@wordpress/element";
import "./Shop.css";
import Card from "./Card";
import axios from "axios";
import ShowRoom from "./ShowRoom";
import { STORE_NAME } from "../store";
import { useSelect } from '@wordpress/data';

const Shop = (props) => {
	const { wapuu, items, categories } = useSelect( select => {
		return {
			wapuu: select(STORE_NAME).getWapuu(),
			items: select(STORE_NAME).getItems(),
			categories: select(STORE_NAME).getCategories()
		};
	});

	const [name, setName] = useState(wapuu.name);
	const [loader, setLoader] = useState("Save");
	const url = wpPluginParam.apiUrl + "/v1/wapuu";

	const nameHandler = (event) => {
		setName(event.target.value);
	};

	const wapuuHandler = (wapuuConfig) => {
		props.onChangeWapuuConfig(wapuuConfig);
	};

	const resetHandler = () => {
		axios.get(url).then((res) => {
			res.data.name = name;
			wapuuHandler(res.data);
		});
	};

	const submitHandler = (event) => {
		event.preventDefault();
		setLoader("Saving...");
		wapuu.name = name;

		axios
			.post(
				url,
				{
					wapuu: wapuu,
				},
				{
					headers: {
						"content-type": "application/json",
						"X-WP-NONCE": wpPluginParam.nonce,
					},
				}
			)
			.then((res) => {
				setLoader("Save");
			});
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
						<svg width="17" height="12" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 12">
							<path fill="#fff" d="M8.896 4.24a3.888 3.888 0 0 0-3.88 3.88A3.888 3.888 0 0 0 8.896 12a3.888 3.888 0 0 0 3.88-3.88 3.889 3.889 0 0 0-3.88-3.88Zm1.847 4.41c-.29 0-.53-.24-.53-.53a1.33 1.33 0 0 0-1.317-1.317.533.533 0 0 1-.53-.53c0-.29.24-.53.53-.53a2.4 2.4 0 0 1 2.394 2.394c0 .273-.24.513-.547.513ZM6.247 3.111c.085.205.29.325.496.325a.854.854 0 0 0 .205-.034.534.534 0 0 0 .29-.701L6.725 1.47a.548.548 0 0 0-.7-.29.534.534 0 0 0-.291.7l.513 1.231Zm-.957.633L3.922 2.376a.537.537 0 0 0-.752 0 .537.537 0 0 0 0 .752l1.367 1.368a.53.53 0 0 0 .377.154.53.53 0 0 0 .376-.154.537.537 0 0 0 0-.752ZM3.888 5.47l-1.23-.513a.534.534 0 0 0-.702.29.534.534 0 0 0 .29.702l1.232.512a.433.433 0 0 0 .205.035c.205 0 .41-.12.495-.325.103-.274-.017-.598-.29-.701Zm-.103 2.65a.532.532 0 0 0-.53-.53H1.307c-.29 0-.53.239-.53.53 0 .29.24.53.53.53h1.948c.291 0 .53-.24.53-.53Zm-.307 1.675-1.231.513a.534.534 0 0 0-.29.7c.085.206.29.325.495.325a.852.852 0 0 0 .205-.034l1.23-.513a.534.534 0 0 0 .291-.7.533.533 0 0 0-.7-.291Zm12.068.495-1.23-.512a.534.534 0 0 0-.702.29.534.534 0 0 0 .291.701l1.23.513a.432.432 0 0 0 .206.034c.205 0 .41-.12.495-.325a.548.548 0 0 0-.29-.7Zm.94-2.7h-1.948c-.29 0-.53.24-.53.53 0 .29.24.53.53.53h1.931c.29 0 .53-.24.53-.53a.508.508 0 0 0-.513-.53Zm-2.872-1.419a.54.54 0 0 0 .496.325.855.855 0 0 0 .205-.034l1.231-.513a.534.534 0 0 0 .29-.701.548.548 0 0 0-.7-.29l-1.231.512c-.273.103-.393.427-.29.701Zm1.026-3.795a.537.537 0 0 0-.752 0L12.52 3.744a.537.537 0 0 0 0 .752.53.53 0 0 0 .376.154.53.53 0 0 0 .376-.154l1.368-1.368a.537.537 0 0 0 0-.752Zm-3.795 1.026a.433.433 0 0 0 .205.034.54.54 0 0 0 .496-.325l.513-1.23a.534.534 0 0 0-.29-.701.534.534 0 0 0-.702.29l-.513 1.23a.549.549 0 0 0 .291.702Zm-1.948-.393c.29 0 .53-.24.53-.53V.529c0-.29-.24-.529-.53-.529-.291 0-.53.24-.53.53v1.932c0 .307.239.546.53.546Z"/>
						</svg>
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
