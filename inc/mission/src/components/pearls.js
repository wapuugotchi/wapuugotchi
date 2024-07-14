import './pearls.scss';
import Pearl from './assets/pearl.svg';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';

/**
 * Pearls component to display the mission reward.
 * Utilizes the global store to fetch the reward details.
 */
export default function Pearls() {
	// Fetching reward details from the store
	const { reward } = useSelect( ( select ) => ( {
		reward: select( STORE_NAME ).getReward(),
	} ) );

	// Render the reward information with an accompanying pearl image
	return (
		<div className="wapuugotchi_missions__pearls">
			You will receive:
			<span>
				{ reward }
				<img alt="Pearl" src={ Pearl } />
			</span>
		</div>
	);
}
