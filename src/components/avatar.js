import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';
import Bubble from './bubble';
import './avatar.scss';
import { useEffect, useState } from '@wordpress/element';

export default function Avatar() {
	const { svg, animations } = useSelect( ( select ) => {
		return {
			svg: select( STORE_NAME ).getSvg(),
			animations: select( STORE_NAME ).getAnimations(),
		};
	} );
	const [ count, setCount ] = useState( 1000 );

	useEffect( () => {
		if ( animations !== undefined ) {
			setTimeout( () => {
				const style = document
					?.getElementById( 'wapuugotchi_svg__wapuu' )
					?.querySelectorAll( 'style' );
				if ( style?.length ) {
					style.forEach( () =>
						document
							?.getElementById( 'wapuugotchi_svg__wapuu' )
							?.querySelectorAll( 'style' )[ 0 ]
							?.remove()
					);
				}

				// get random animation
				const item =
					animations[
						Math.floor( Math.random() * animations.length )
					];

				if ( item?.animation?.rules?.length > 0 ) {
					Object.values( item.animation.rules ).forEach( function (
						element
					) {
						const tag = document.createElement( 'style' );
						tag.innerHTML = element.cssText;
						document
							.getElementById( 'wapuugotchi_svg__wapuu' )
							.prepend( tag );
					} );
				}
				setCount(
					( Math.floor( Math.random() * 15 ) + 5 + item.duration ) *
						1000
				);
			}, count );
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
