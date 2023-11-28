import './guide-content.scss';
import GuideTitle from "./guide-title";
import GuideText from "./guide-text";
import GuideControl from "./guide-control";
import GuideFooter from "./guide-footer";


export default function GuideContent() {
	return (
		<>
			<div className="wapuugotchi_onboarding_guide__content">
				<img src="https://s.w.org/images/block-editor/welcome-canvas.gif" width="312" height="240" alt="" />
				<GuideControl />
				<GuideTitle />
				<GuideText />
			</div>
		</>
	);
}
