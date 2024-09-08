import './overlay.scss';
import { useEffect } from '@wordpress/element';

/**
 * Overlay component to manage the visibility of the overlay.
 */
export default function Overlay() {
	useEffect( () => {
		const hideAction = ( event ) => {
			if (
				event.target.classList.contains(
					'wapuugotchi_mission__overlay'
				)
			) {
				event.target.classList.add( 'hidden' );
			}
		};

		const hideOnEscape = ( event ) => {
			if ( event.key === 'Escape' ) {
				const overlay = document.querySelector(
					'.wapuugotchi_mission__overlay'
				);
				if ( overlay ) {
					overlay.classList.add( 'hidden' );
				}
			}
		};

		const overlay = document.querySelector(
			'.wapuugotchi_mission__overlay'
		);
		overlay.addEventListener( 'click', hideAction );
		document.addEventListener( 'keydown', hideOnEscape );

		// Cleanup the event listener on component unmount
		return () => {
			overlay.removeEventListener( 'click', hideAction );
			document.removeEventListener( 'keydown', hideOnEscape );
		};
	}, [] );

	return <div className="wapuugotchi_mission__overlay hidden"></div>;
}
