/**
 * @file overlay.js
 * @description This file contains the Overlay component which manages the visibility of the overlay.
 * The component uses the `useEffect` hook to add event listeners for hiding the overlay on click or escape key press.
 * It also adjusts the overlay's position and size based on the admin menu and admin bar.
 */
import './overlay.scss';
import { useEffect } from '@wordpress/element';
import { adjustStoryContainer, setupObservers } from '../utils/overlayUtils';

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
		adjustStoryContainer( overlay );
		setupObservers( overlay );

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
