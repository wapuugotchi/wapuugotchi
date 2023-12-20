import './overlay.scss';
import Dialog from "./dialog";
import {dispatch, useSelect} from "@wordpress/data";
import { useState } from '@wordpress/element';

import {STORE_NAME} from "../../store/onboarding";
import Navigation from "./navigation";
import Focus from "./focus";


export default function Overlay() {
	const {index, pageConfig} = useSelect((select) => {
		return {
			index: select(STORE_NAME).getIndex(),
			pageConfig: select(STORE_NAME).getPageConfig(),
		};
	});

	return (
		<>
			<div id="wapuugotchi_onboarding__overlay">
				<div className="wapuugotchi_onboarding__dialog">
					<Focus />
					<Dialog param={[]}/>
				</div>
			</div>
		</>
	);
}
