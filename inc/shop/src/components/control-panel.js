import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { useState } from '@wordpress/element';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import './control-panel.scss';

export default function ControlPanel() {
	const { wapuu } = useSelect( ( select ) => {
		return {
			wapuu: select( STORE_NAME ).getWapuu(),
		};
	} );

	const [ name, setName ] = useState( wapuu?.name );
	const [ loader, setLoader ] = useState( __( 'Ausrüsten!', 'wapuugotchi' ) );


	const submitHandler = async ( event ) => {
		event.preventDefault();
		setLoader( __( 'Speichere…', 'wapuugotchi' ) );
		wapuu.name = name;
		const svgEl = document.querySelector( '#wapuugotchi_svg__wapuu' );
		await apiFetch( {
			path: `wapuugotchi/v1/wapuugotchi/shop/update-avatar`,
			method: 'POST',
			data: {
				avatar: wapuu,
				svg: svgEl ? svgEl.outerHTML : '',
			},
		} );
		setLoader( __( 'Ausrüsten!', 'wapuugotchi' ) );
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
				className="wapuugotchi_shop__submit"
				onClick={ submitHandler }
			>
				{ loader }
			</button>
		</div>
	);
}
