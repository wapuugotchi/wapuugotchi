import './global-navigation.scss';
import {useSelect} from "@wordpress/data";

import {STORE_NAME} from "../../store/onboarding";


export default function GlobalNavigation() {
	const {index} = useSelect((select) => {
		return {
			index: select(STORE_NAME).getIndex(),
		};
	});

	return (
		<>
			<div id="wapuugotchi_onboarding__global_navigation">
			</div>
		</>
	);
}
