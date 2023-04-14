import { render, StrictMode } from "@wordpress/element";
import domReady from "@wordpress/dom-ready";
import App from "./app";

domReady(() =>
	render(
		<StrictMode>
			<App />
		</StrictMode>,
		document.getElementById("wapuugotchi-app")
	)
);
