import './overlay.scss';
import Dialog from './dialog';
import { useSelect } from '@wordpress/data';

import { STORE_NAME } from '../../store/onboarding';
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
					pageConfig?.[ index ]?.targets?.[ 0 ]?.hover === true
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
