import './page.scss';
import Map from './map';
import Description from './description';
import Steps from './steps';
import Overlay from './overlay';

/**
 * Page component that assembles the mission page.
 * It includes the map, mission description, steps, and overlay components.
 */
export default function Page() {
	return (
		<>
			<div className="wapuugotchi_missions__page">
				<Map />
				<Description />
				<Steps />
				<Overlay />
			</div>
		</>
	);
}
