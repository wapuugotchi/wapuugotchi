import './overlay.scss';
import Guide from "./guide";
import Node from "./node";

export default function Overlay() {
	const getStep = () => {
		const element = 'guide'
		switch (element) {
			case 'guide':
				return <Guide param={[]} />;
			case 'node':
				return <Node param={[]} />;
		}
	}

	return (
		<>
			<div id="wapuugotchi_onboarding__overlay">
				{getStep()}
			</div>
		</>
	);
}
