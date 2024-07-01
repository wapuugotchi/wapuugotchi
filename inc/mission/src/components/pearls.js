import './pearls.scss';
import Pearl from './assets/pearl.svg';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';

export default function Pearls() {
	const { reward } = useSelect( ( select ) => {
		return {
			reward: select( STORE_NAME ).getReward(),
		};
	} );
	return (
		<>
			<div className="wapuugotchi_missions__pearls">
				You will receive:
				<span>
					{ reward }
					<img alt="" src={ Pearl } />
				</span>
			</div>
		</>
	);
}
