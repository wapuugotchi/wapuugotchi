import './guide-control.scss';
import closing_guide from './guide-control-dot.svg';
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";


export default function GuideControl( param ) {
	const isActive = ( item ) => {
		return item === 1;
	}

	return (

		<>
			<div className="wapuugotchi_onboarding_guide__control">
				<ul>
					{
						param.index?.map(
							( index, key ) => (
								<li key={ "guide-control_" + key }>
										{ isActive( key )
											? <button className="components-button has-icon"><svg width="8" height="8" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><circle cx="4" cy="4" r="4" fill="#419ECD"></circle></svg></button>
											: <button className="components-button has-icon"><svg width="8" height="8" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" focusable="false"><circle cx="4" cy="4" r="4" fill="#E1E3E6"></circle></svg></button>
										}
								</li>
							)
						)
					}
				</ul>
			</div>
		</>
	);
}
