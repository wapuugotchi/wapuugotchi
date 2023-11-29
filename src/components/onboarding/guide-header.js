import './guide-header.scss';
import closing_guide from './guide-header-close.svg';


export default function GuideHeader() {

	const guideClose = async () => {
		console.log('close guide')
	};

	return (
		<>
			<div className="wapuugotchi_onboarding_guide__headline">
				<button type="button" className="components-button has-icon" aria-label="Close" onClick={ guideClose }>
					<img src={ closing_guide }  alt="closing button"/>
				</button>
			</div>
		</>
	);
}
