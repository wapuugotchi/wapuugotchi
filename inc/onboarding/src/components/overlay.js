import './overlay.scss';
import Dialog from './dialog';
import { useSelect } from '@wordpress/data';

import { STORE_NAME } from '../store';
import Focus from './focus';

export default function Overlay() {
	const { index, pageConfig } = useSelect( ( select ) => {
		return {
			index: select( STORE_NAME ).getIndex(),
			pageConfig: select( STORE_NAME ).getPageConfig(),
		};
	} );

	return (
		<>
			<div
				id="wapuugotchi_onboarding__overlay"
				className={
					pageConfig?.[ index ]?.target_list?.[ 0 ]?.hover === 1
						? 'unlocked'
						: ''
				}
			>
				<div className="wapuugotchi_onboarding__dialog">
					<Focus />
					<Dialog param={ [] } />
				</div>
			</div>
		</>
	);
}
