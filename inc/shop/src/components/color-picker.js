import { useState, useEffect, useRef } from '@wordpress/element';
import { dispatch } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { STORE_NAME } from '../store';
import './color-picker.scss';

function getSlots( svgEl, itemKeys ) {
	return itemKeys.flatMap( ( itemKey ) => {
		const prefix = `data-color-${ itemKey }-`;
		return svgEl
			.getAttributeNames()
			.filter( ( attr ) => attr.startsWith( prefix ) )
			.sort()
			.map( ( attr ) => ( {
				key: attr,
				label: svgEl.getAttribute( attr ),
				variable: `--wapuu-color-${ itemKey }-${ attr.slice(
					prefix.length
				) }`,
			} ) );
	} );
}

function getInitialColors( svgEl, slots ) {
	return Object.fromEntries(
		slots.map( ( slot ) => {
			const raw = svgEl.style.getPropertyValue( slot.variable ).trim();
			const value = /^#[0-9a-f]{6}$/i.test( raw ) ? raw : '#cccccc';
			return [ slot.key, value ];
		} )
	);
}

export default function ColorPicker( { svgEl, itemKeys } ) {
	const slots = getSlots( svgEl, itemKeys );
	const [ isOpen, setIsOpen ] = useState( false );
	const [ colors, setColors ] = useState( () =>
		getInitialColors( svgEl, slots )
	);
	const pickerRef = useRef( null );

	useEffect( () => {
		setColors( getInitialColors( svgEl, getSlots( svgEl, itemKeys ) ) );
	}, [ svgEl, itemKeys ] );

	useEffect( () => {
		if ( ! isOpen ) {
			return;
		}
		const handleOutside = ( e ) => {
			if ( ! pickerRef.current?.contains( e.target ) ) {
				setIsOpen( false );
			}
		};
		document.addEventListener( 'mousedown', handleOutside );
		return () => document.removeEventListener( 'mousedown', handleOutside );
	}, [ isOpen ] );

	if ( ! slots.length ) {
		return null;
	}

	const handleColorChange = ( slot, value ) => {
		svgEl.style.setProperty( slot.variable, value );
		setColors( ( prev ) => ( { ...prev, [ slot.key ]: value } ) );
		dispatch( STORE_NAME ).updateWapuuColor( slot.variable, value, svgEl.outerHTML );
	};

	const handleReset = () => {
		dispatch( STORE_NAME ).resetWapuuColors();
		setIsOpen( false );
	};

	return (
		<div ref={ pickerRef } className="wapuugotchi_shop__color_picker">
			<div className="wapuugotchi_shop__color_picker_buttons">
				<button
					className="wapuugotchi_shop__color_picker_reset"
					onClick={ handleReset }
					title={ __( 'Farben zurücksetzen', 'wapuugotchi' ) }
				>
					<ResetIcon />
				</button>
				<button
					className={ `wapuugotchi_shop__color_picker_toggle${
						isOpen ? ' is-open' : ''
					}` }
					onClick={ () => setIsOpen( ( o ) => ! o ) }
					title={ __( 'Farbe anpassen', 'wapuugotchi' ) }
				>
					<PaletteIcon />
				</button>
			</div>
			{ isOpen && (
				<div className="wapuugotchi_shop__color_picker_panel">
					{ slots.map( ( slot ) => (
						<label
							key={ slot.key }
							className="wapuugotchi_shop__color_slot"
						>
							<input
								type="color"
								value={ colors[ slot.key ] }
								onChange={ ( e ) =>
									handleColorChange( slot, e.target.value )
								}
							/>
							<span
								className="wapuugotchi_shop__color_swatch"
								style={ { background: colors[ slot.key ] } }
							/>
							{ slot.label }
						</label>
					) ) }
				</div>
			) }
		</div>
	);
}

function ResetIcon() {
	return (
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			aria-hidden="true"
			focusable="false"
		>
			<path d="M12 5V2L8 6l4 4V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z" />
		</svg>
	);
}

function PaletteIcon() {
	return (
		<svg
			xmlns="http://www.w3.org/2000/svg"
			viewBox="0 0 24 24"
			aria-hidden="true"
			focusable="false"
		>
			<path d="M12 2C6.49 2 2 6.49 2 12s4.49 10 10 10c.89 0 1.75-.13 2.59-.37.58-.17.94-.76.77-1.34-.18-.59-.78-.94-1.38-.77-.63.18-1.29.27-1.98.27-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8c0 1.1-.89 2-2 2s-2-.9-2-2c0-1.1-.9-2-2-2s-2 .9-2 2c0 2.21 1.79 4 4 4 .73 0 1.41-.21 2-.57C19.41 19.27 22 15.97 22 12c0-5.51-4.49-10-10-10zM7 13c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2-4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm6 0c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm2 4c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1z" />
		</svg>
	);
}
