import { useState } from "@wordpress/element";
import "./Shop.css";
import Card from "./Card";
import axios from "axios";
import ShowRoom from "./ShowRoom";

const Shop = (props) => {
	const [name, setName] = useState(props.wapuu.name);
	const [wapuu, setWapuu] = useState(props.wapuu);
	const [loader, setLoader] = useState("Save Wapuu");
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
		props.wapuu.name = name;

		axios
			.post(
				url,
				{
					wapuu: props.wapuu,
				},
				{
					headers: {
						"content-type": "application/json",
						"X-WP-NONCE": wpPluginParam.nonce,
					},
				}
			)
			.then((res) => {
				setLoader("Save Settings");
			});
	};

	return (
		<div className="wapuu_shop">
			<form onSubmit={submitHandler}>
				<Card
					collection={props.collection}
					lockedCollection={props.lockedCollection}
					wapuu={props.wapuu}
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
							<ShowRoom wapuu={props.wapuu} collection={props.collection} />
						</div>
					</div>
					<div className="wapuu_shop__button">
						<button
							onClick={resetHandler}
							className="button button-secondary wapuu_shop__reset"
							type="button"
						>
							Clear
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
