import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../../store';
import { useCallback, useEffect } from '@wordpress/element';
import { adjustStoryContainer, setupObservers } from '../../utils/overlayUtils';
import './sought.scss';

export default function Sought() {
	const { avatar } = useSelect( ( select ) => ( {
		avatar: select( STORE_NAME ).getAvatar(),
	} ) );

	const prepareSvg = useCallback( ( svgString ) => {
		const parser = new DOMParser();
		const doc = parser.parseFromString( svgString, 'image/svg+xml' );
		return doc.querySelector( 'svg' ).innerHTML;
	}, [] );

	useEffect( () => {
		const overlay = document.querySelector(
			'.wapuugotchi_mission__overlay'
		);

		if ( overlay ) {
			const hideAction = ( event ) => {
				if (
					event.key === 'Escape' ||
					event.target.classList.contains(
						'wapuugotchi_mission__overlay'
					)
				) {
					window.location.href =
						'/wp-admin/admin.php?page=wapuugotchi';
				}
			};

			adjustStoryContainer( overlay );
			const cleanupObservers = setupObservers( overlay );

			overlay.addEventListener( 'click', hideAction );
			document.addEventListener( 'keydown', hideAction );

			return () => {
				overlay.removeEventListener( 'click', hideAction );
				document.removeEventListener( 'keydown', hideAction );
				cleanupObservers();
			};
		}
	}, [] );

	return (
		<div className="wapuugotchi_mission__overlay">
			<div className="wapuugotchi_mission__action">
				<svg
					id="wapuugotchi_hunt__svg"
					xmlns="http://www.w3.org/2000/svg"
					height="100%"
					width="100%"
					version="1.1"
					viewBox="0 0 1000 1000"
					dangerouslySetInnerHTML={ { __html: prepareSvg( avatar ) } }
				></svg>
			</div>
		</div>
	);
}
