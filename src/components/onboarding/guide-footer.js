import './guide-footer.scss';
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";

export default function GuideFooter( param ) {

	const { current } = useSelect( ( select ) => {
		return {
			current: select( STORE_NAME ).getCurrent(),
		};
	} );

	const handleNext = () => {
		param.onHandleClick("next");
	};

	return (
		<>
			<div className="wapuugotchi_onboarding_guide__footer">
				<button className="components-button" onClick={ handleNext }>Next</button>
			</div>
		</>
	);
}
