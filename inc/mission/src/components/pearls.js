import './pearls.scss';
import Pearl from './assets/pearl.svg';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { STORE_NAME } from '../store';

/**
 * Pearls component to display the mission reward.
 * Utilizes the global store to fetch the reward details.
 */
export default function Pearls() {
	// Fetching reward details from the store
	const { reward, progress, markers } = useSelect( ( select ) => ( {
		reward: select( STORE_NAME ).getReward(),
		progress: select( STORE_NAME ).getProgress(),
		markers: select( STORE_NAME ).getMarkers(),
	} ) );

	// Determine if the reward has been transferred
	const rewardTransferred = progress === markers;

	// Render the reward information with an accompanying pearl image
	return (
		<div
			className={ `wapuugotchi_missions__pearls ${
				rewardTransferred ? 'reward-transferred' : ''
			}` }
		>
			<img alt="Pearl" src={ Pearl } />+{ reward }{ ' ' }
			{ __( 'pearls', 'wapuugotchi' ) }
		</div>
	);
}
