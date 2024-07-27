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

		const overlay = document.querySelector(
			'.wapuugotchi_mission__overlay'
		);
		overlay.addEventListener( 'click', hideAction );

		// Cleanup the event listener on component unmount
		return () => overlay.removeEventListener( 'click', hideAction );
	}, [] );

	return <div className="wapuugotchi_mission__overlay hidden"></div>;
}
