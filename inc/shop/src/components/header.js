import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { __ } from '@wordpress/i18n';
import './header.scss';
import Pearl from './assets/pearl.svg';

export default function Header() {
	const { balance } = useSelect( ( select ) => {
		return {
			balance: select( STORE_NAME ).getBalance(),
		};
	} );

	return (
		<div className="wapuugotchi_shop__header">
			<h1 className="wapuugotchi_shop__title">
				{ __( 'Customize Your Wapuu with WapuuGotchi', 'wapuugotchi' ) }
			</h1>
			<span className="wapuugotchi_shop__pearls">
				{ __( 'Your Pearl Balance:', 'wapuugotchi' ) }
				<img alt="" src={ Pearl } />
				{ balance }
			</span>
		</div>
	);
}
