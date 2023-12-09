import './guide-text.scss';
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";


export default function GuideText( param ) {
	return (
		<>
			<div className="wapuugotchi_onboarding_guide__text">
				<p>{ param?.text }</p>
			</div>
		</>
	);
}
