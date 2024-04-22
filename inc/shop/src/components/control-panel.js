import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import './control-panel.scss';

export default function ControlPanel() {
	const { wapuu, svg } = useSelect( ( select ) => {
		return {
			wapuu: select( STORE_NAME ).getWapuu(),
			svg: select( STORE_NAME ).getSvg(),
		};
	} );

	const [ name, setName ] = useState( wapuu?.name );
	const [ loader, setLoader ] = useState( __( 'Save', 'wapuugotchi' ) );

	const buildSvg = ( svgString ) => {
		return (
			'<svg xmlns="http://www.w3.org/2000/svg" x="0" y="0" version="1.1" viewBox="0 0 1000 1000">' +
			svgString +
			'</svg>'
		);
	};

	const submitHandler = async ( event ) => {
		event.preventDefault();
		setLoader( __( 'Saving…', 'wapuugotchi' ) );
		wapuu.name = name;
		await apiFetch( {
			path: `wapuugotchi/v1/wapuugotchi/shop/update-avatar`,
			method: 'POST',
			data: {
				avatar: wapuu,
				svg: buildSvg( svg ),
			},
		} );
		setLoader( __( 'Save', 'wapuugotchi' ) );
	};

	return (
		<div className="wapuugotchi_shop__control_panel">
			<input
				className="wapuugotchi_shop__name"
				type="text"
				value={ name }
				onChange={ ( e ) => setName( e.target.value ) }
			/>
			<button
				className="button button-primary wapuugotchi_shop__submit"
				onClick={ submitHandler }
			>
				{ loader }
			</button>
		</div>
	);
}
