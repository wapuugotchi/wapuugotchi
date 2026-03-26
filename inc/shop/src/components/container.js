import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { STORE_NAME } from '../store';
import PaymentDialog from './payment-dialog';
import LeftSide from './left-side';
import RightSide from './right-side';
import Pearl from './assets/pearl_black.svg';

import './container.scss';

export default function Container() {
	const { balance } = useSelect( ( select ) => {
		return {
			balance: select( STORE_NAME ).getBalance(),
		};
	} );

	return (
		<div className="wapuugotchi_shop__page">
			<div className="wapuugotchi_shop__page_header">
				<div className="wapuugotchi_shop__page_title">
					<h1>{ __( '🐾 WapuuGotchi – Shop', 'wapuugotchi' ) }</h1>
					<p className="subtitle">
						{ __(
							'Style your Wapuu, unlock fresh looks, and spend pearls on new gear.',
							'wapuugotchi'
						) }
					</p>
				</div>
				<div className="wapuugotchi_shop__page_pill">
					<img alt="" src={ Pearl } />
					{ balance } { __( 'Pearls', 'wapuugotchi' ) }
				</div>
			</div>
			<div className="wapuugotchi_shop">
				<PaymentDialog />
				<div className="wapuugotchi_shop__customizer">
					<LeftSide />
					<RightSide />
				</div>
			</div>
		</div>
	);
}
