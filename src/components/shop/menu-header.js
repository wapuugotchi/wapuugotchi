import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../../store/wapuu';
import { __ } from '@wordpress/i18n';
import './menu-header.scss';
import priceTag from './category-item-pricetag.svg';

export default function MenuHeader( props ) {
	const { balance } = useSelect( ( select ) => {
		return {
			balance: select( STORE_NAME ).getBalance(),
		};
	} );

	return (
		<div className="wapuu_shop__header">
			<h1 className="wapuu_shop__title">{ props.title }</h1>
			{ /*<span className="wapuu_shop__divider" />*/ }
			<p className="wapuu_shop__description">{ props.description }</p>
			<span className="wapuu_shop__pearls">
				{ __( 'Your Pearl Balance:', 'wapuugotchi' ) }
				<img alt="" src={ priceTag } />
				{ balance }
			</span>
		</div>
	);
}
