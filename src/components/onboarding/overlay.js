import './overlay.scss';
import Dialog from "./dialog";
import {dispatch, useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";

export default function Overlay() {
	const {index, pageConfig} = useSelect((select) => {
		return {
			index: select(STORE_NAME).getIndex(),
			pageConfig: select(STORE_NAME).getPageConfig(),
		};
	});
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
	fadeOut();
	const next = () => {
		let keyList = Object.keys(pageConfig)
		let indexPosition = keyList?.indexOf(index)

		if (indexPosition >= 0 && keyList?.length > indexPosition) {
			let nextIndex = keyList[indexPosition + 1];
			if (pageConfig?.[nextIndex] !== undefined) {
				dispatch(STORE_NAME).setIndex(nextIndex);

			}
		}
	}

	return (
		<>
			<div id="wapuugotchi_onboarding__overlay" onClick={next}>
				<div className="wapuugotchi_onboarding__dialog">
					<Dialog param={[]}/>;
				</div>
			</div>
		</>
	);
}
