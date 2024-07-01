import './overlay.scss';
import { useEffect } from '@wordpress/element';
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
		document
			.querySelector( '.wapuugotchi_mission__overlay' )
			?.addEventListener( 'click', hideAction );
	}, [] );

	return (
		<>
			<div className="wapuugotchi_mission__overlay hidden"></div>
		</>
	);
}
