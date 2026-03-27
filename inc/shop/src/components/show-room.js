import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';
import { useRef, useState, useEffect, useMemo } from '@wordpress/element';
import ColorPicker from './color-picker';
import './show-room.scss';

export default function ShowRoom() {
	const { svg, wapuu } = useSelect( ( select ) => {
		return {
			svg: select( STORE_NAME ).getSvg(),
			wapuu: select( STORE_NAME ).getWapuu(),
		};
	} );

	const memorizedAvatar = svg;

	const containerRef = useRef( null );
	const [ svgEl, setSvgEl ] = useState( null );

	const colorableItemKeys = useMemo( () => {
		if ( ! svgEl ) {
			return [];
		}
		return Object.values( wapuu?.char || {} ).flatMap( ( charEntry ) =>
			( charEntry?.key || [] ).filter( ( key ) =>
				svgEl
					.getAttributeNames()
					.some( ( attr ) =>
						attr.startsWith( `data-color-${ key }-` )
					)
			)
		);
	}, [ svgEl, wapuu ] );

	useEffect( () => {
		const el = containerRef.current?.querySelector( 'svg.color_pick_able' );
		setSvgEl( el ?? null );
	}, [ memorizedAvatar ] );

	return (
		<div className="wapuugotchi_shop__image">
			<div
				ref={ containerRef }
				className="wapuu_show_room"
				dangerouslySetInnerHTML={ { __html: memorizedAvatar } }
			/>
			{ svgEl && colorableItemKeys.length > 0 && (
				<ColorPicker svgEl={ svgEl } itemKeys={ colorableItemKeys } />
			) }
		</div>
	);
}
