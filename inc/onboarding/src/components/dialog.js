import './dialog.scss';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import Wapuu from './wapuu';
import Navigation from './navigation';

export default function Dialog() {
	const { index, pageConfig } = useSelect( ( select ) => {
		return {
			index: select( STORE_NAME ).getIndex(),
			pageConfig: select( STORE_NAME ).getPageConfig(),
		};
	} );

	return (
		<>
			<div className="wapuugotchi_onboarding__guide">
				<Navigation />
				<div className="wapuugotchi_onboarding__guide_text">
					<p>{ pageConfig?.[ index ]?.text }</p>
				</div>
				<Wapuu />
			</div>
		</>
	);
}
