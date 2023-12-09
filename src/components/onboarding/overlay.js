import './overlay.scss';
import Guide from "./guide";
import Node from "./node";
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";

export default function Overlay() {

	const { config, next, page } = useSelect( ( select ) => {
		return {
			config: select( STORE_NAME ).getConfig(),
			next: select( STORE_NAME ).getNext(),
			page: select( STORE_NAME ).getPage(),
		};
	} );

	const fadeOut = () => {
		let fadeTarget = document.getElementById("wapuugotchi__avatar");
		let fadeEffect = setInterval(function () {
			if (!fadeTarget.style.opacity) {
				fadeTarget.style.opacity = 1;
			}
			if (fadeTarget.style.opacity > 0) {
				fadeTarget.style.opacity -= 0.1;
			} else {
				clearInterval(fadeEffect);
			}
		}, 10);
	}
	const fadeIn = () => {
		let fadeTarget = document.getElementById("wapuugotchi__avatar");
		let fadeEffect = setInterval(function () {
			if (!fadeTarget.style.opacity) {
				fadeTarget.style.opacity = 0;
			}
			if (fadeTarget.style.opacity < 1) {
				fadeTarget.style.opacity += 0.1;
			} else {
				clearInterval(fadeEffect);
			}
		}, 10);
	}

	const getStep = () => {
		const element = 'guide'
		switch (element) {
			case 'guide':
				{fadeOut()}
				return <Guide param={[]} />;
			case 'node':
				{fadeIn()}
				return <Node param={[]} />;
		}
	}

	return (
		<>
			<div id="wapuugotchi_onboarding__overlay">
				{getStep()}
			</div>
		</>
	);
}
