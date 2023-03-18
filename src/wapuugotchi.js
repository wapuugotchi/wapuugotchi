import apiFetch from "@wordpress/api-fetch";
import "./wapuugotchi.css";
class Wapuu {
	constructor() {
		this.set_image();
	}

	async set_image() {
		let div = document.createElement("DIV");
		div.id = "wapuugotchi";
		div.innerHTML = wpPluginParam.wapuu;

		document.getElementById("wpwrap").append(div);
		apiFetch.use(apiFetch.createNonceMiddleware(window.wpPluginParam.nonce));

		const res = await apiFetch({ path: "/wapuugotchi/v1/message" });

		// TODO: code React from here on
		console.log(res);
	}
}

new Wapuu();
