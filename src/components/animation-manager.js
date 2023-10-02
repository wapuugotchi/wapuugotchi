import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';
import './animation-manager.scss';
import { useEffect, useState } from '@wordpress/element';

export default function AnimationManager() {
	const { animations } = useSelect( ( select ) => {
		return {
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

				// Insert random animation in DOM
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
	}, [ animations, count ] );
	return false;
}
