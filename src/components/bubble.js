import { useState } from "@wordpress/element";
import { useSelect, dispatch } from "@wordpress/data";
import apiFetch from "@wordpress/api-fetch";
import { STORE_NAME } from "../store";
import "./bubble.scss";

export default function Bubble() {
	let { restBase, message } = useSelect((select) => {
		return {
			restBase: select(STORE_NAME).getRestBase(),
			message: select(STORE_NAME).getMessage(),
		};
	})

	return (
		<>
			{console.log(message)}
			<div className="rubbelDieKatz">Test</div>
		</>
	);
}

