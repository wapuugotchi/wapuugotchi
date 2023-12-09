import { useSelect, dispatch } from '@wordpress/data';
import { STORE_NAME } from '../../store/onboarding';
import './main.scss';
import Overlay from "./overlay";

export default function Main() {
		return (
		<>
			<Overlay />
		</>
	);
}
