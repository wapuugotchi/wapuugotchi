import './guide.scss';
import GuideHeader from "./guide-header";
import GuideContent from "./guide-content";
import GuideFooter from "./guide-footer";


export default function Guide() {
	return (
		<>
			<div className="wapuugotchi_onboarding__guide">
				<GuideHeader />
				<GuideContent />
				<GuideFooter />
			</div>
		</>
	);
}
