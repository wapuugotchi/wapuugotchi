import { render, StrictMode } from "@wordpress/element";
import domReady from "@wordpress/dom-ready";


domReady(() =>
	render(
		<StrictMode>
		</StrictMode>,
		document.getElementById("wapuugotchi-app")
	)
);
