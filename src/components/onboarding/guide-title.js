import './guide-title.scss';
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";

export default function GuideTitle(param) {

	return (
		<>
			<div className="wapuugotchi_onboarding_guide__title">
				<h1>{ param?.title }</h1>
			</div>
		</>
	);
}
