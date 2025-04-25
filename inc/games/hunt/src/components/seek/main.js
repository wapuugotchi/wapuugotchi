import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../../store';
import './main.scss';
import HiddenSVG from './hidden';
import SoughtSVG from './sought';

export default function Hidden() {
	const { completed } = useSelect( ( select ) => ( {
		completed: select( STORE_NAME ).getCompleted(),
	} ) );

	return completed === true ? <SoughtSVG /> : <HiddenSVG />;
}
