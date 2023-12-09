import './guide-content.scss';
import GuideTitle from "./guide-title";
import GuideText from "./guide-text";
import GuideControl from "./guide-control";
import GuideImage from "./guide-image";


export default function GuideContent( prop ) {

	return (
		<>
			<div className="wapuugotchi_onboarding_guide__content" >
				<GuideImage image={ prop?.current?.image } />
				<GuideTitle title={ prop?.current?.title } />
				<GuideText text={ prop?.current?.text } />
			</div>
		</>
	);
}
