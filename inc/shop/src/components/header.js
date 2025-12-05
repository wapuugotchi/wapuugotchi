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
			<div className="wapuugotchi_shop__title">
				<h1>{ __( '🐾 WapuuGotchi – Shop', 'wapuugotchi' ) }</h1>
				<p className="subtitle">
					{ __(
						'Style your Wapuu, unlock fresh looks, and spend pearls on new gear.',
						'wapuugotchi'
					) }
				</p>
			</div>
			<span className="wapuugotchi_shop__pill">
				<img alt="" src={ Pearl } />
				{ balance } { __( 'pearls', 'wapuugotchi' ) }
			</span>
		</div>
	);
}
