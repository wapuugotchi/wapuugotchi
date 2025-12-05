import './page.scss';
import Header from './header';
import Map from './map';
import Description from './description';
import Overlay from './overlay';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { __, sprintf } from '@wordpress/i18n';

/**
 * Page component that assembles the mission page.
 * It includes the map, mission description, steps, and overlay components.
 */
export default function Page() {
	const { progress, markers } = useSelect( ( select ) => ( {
		progress: select( STORE_NAME ).getProgress(),
		markers: select( STORE_NAME ).getMarkers(),
	} ) );

	const progressLabel = sprintf(
		// translators: 1: current step, 2: total steps.
		__( '%1$d of %2$d checkpoints unlocked', 'wapuugotchi' ),
		progress,
		markers
	);

	return (
		<>
			<div className="wapuugotchi_missions__page">
				<Header progressLabel={ progressLabel } />
				<div className="wapuugotchi_missions__grid">
					<Map />
					<Description />
				</div>
				<Overlay />
			</div>
		</>
	);
}
