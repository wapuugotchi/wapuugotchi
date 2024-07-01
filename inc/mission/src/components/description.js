import './description.scss';
import Pearls from './pearls';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';

export default function Description() {
	const { description } = useSelect( ( select ) => {
		return {
			description: select( STORE_NAME ).getDescription(),
		};
	} );
	return (
		<>
			<div className="wapuugotchi_missions__description">
				<div className="wapuugotchi_missions__headline">
					<h1>Adventure</h1>
					<Pearls />
				</div>
				<p>{ description }</p>
			</div>
		</>
	);
}
