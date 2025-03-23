import { useSelect, dispatch } from '@wordpress/data';
import { STORE_NAME } from '../../store';
import './main.scss';
import HiddenSVG from './hidden';
import SoughtSVG from "./sought";

const HEIGHT = 30;


export default function Hidden() {
	const { completed } = useSelect( ( select ) => ( {
		completed: select( STORE_NAME ).getCompleted(),
	} ) );

	return (
		completed === true ?
			<SoughtSVG /> :
			<HiddenSVG />
	);
}
