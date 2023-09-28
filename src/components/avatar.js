import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';
import Bubble from './bubble';
import './avatar.scss';
import { useEffect, useState } from '@wordpress/element';
import { v4 as uuidv4 } from 'uuid';

export default function Avatar() {
	const { svg, animations } = useSelect( ( select ) => {
		return {
			svg: select( STORE_NAME ).getSvg(),
			animations: select( STORE_NAME ).getAnimations(),
		};
	} );
	const [ count, setCount ] = useState( { timeout: 1000 } );

	useEffect( () => {
		if ( animations !== undefined ) {
			setTimeout( () => {
				// remove all style tags
				document
					.querySelectorAll( 'style' )
					.forEach( ( tag ) => tag.parentNode.removeChild( tag ) );

				// get random animation
				const animation =
					animations[
						Math.floor( Math.random() * animations.length )
					];

				// Insert random animation into DOM
				if ( animation?.animation?.rules?.length > 0 ) {
					Object.values( animation.animation.rules ).forEach(
						function ( element ) {
							const tag = document.createElement( 'style' );
							tag.innerHTML = element.cssText;
							document
								.getElementById( 'wapuugotchi_svg__wapuu' )
								.prepend( tag );
						}
					);
				}
				console.log( animation.animation );

				setCount( {
					...count,
					timeout:
						( Math.floor( Math.random() * 7 ) +
							5 +
							animation.duration ) *
						1000,
				} );
			}, count.timeout );
		}
	} );
	return (
		<>
			<Bubble></Bubble>
			<div className="wapuugotchi__svg">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					id="wapuugotchi_svg__wapuu"
					x="0"
					y="0"
					version="1.1"
					viewBox="0 0 1000 1000"
					dangerouslySetInnerHTML={ { __html: svg } }
				></svg>
			</div>
		</>
	);
}
