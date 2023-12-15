import './dialog.scss';
import {useState} from "@wordpress/element";
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";
import Wapuu from "./wapuu";



export default function Dialog() {

	const { index, pageConfig } = useSelect( ( select ) => {
		return {
			index: select( STORE_NAME ).getIndex(),
			pageConfig: select( STORE_NAME ).getPageConfig(),
		};
	} );

	return (
		<>
			<div className="wapuugotchi_onboarding__guide">
				<div className="wapuugotchi_onboarding__guide_text">
					<p>{pageConfig?.[index]?.text}</p>
				</div>
				<Wapuu />
			</div>
		</>
	);
}
