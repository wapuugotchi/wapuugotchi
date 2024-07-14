import './map.scss';
import { useEffect, useRef } from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { SVG } from '@wordpress/primitives';

export default function Map() {
	const { map, completed } = useSelect( ( select ) => {
		return {
			map: select( STORE_NAME ).getMap(),
			completed: select( STORE_NAME ).getCompleted(),
		};
	} );

	const svgRef = useRef( null );

	useEffect( () => {
		const svgElement = svgRef.current;
		if ( ! svgElement ) {
			return;
		}

		const missionSection = svgElement.querySelector( '#mission_section' );
		if ( ! missionSection ) {
			return;
		}

		const showAction = ( event ) => {
			if ( event.target.parentNode === missionSection ) {
				const action = document.querySelector(
					'.wapuugotchi_mission__overlay'
				);
				action.classList.remove( 'hidden' );
			}
		};

		svgElement?.addEventListener( 'click', showAction );

		// Clean up on unmount
		return () => {
			svgElement?.removeEventListener( 'click', showAction );
		};
	}, [ svgRef ] );

	useEffect( () => {
		const svgElement = svgRef.current;
		if ( ! svgElement ) {
			return;
		}
		const missionSection = svgElement.querySelector(
			'#mission_section text.active'
		);
		if ( ! missionSection ) {
			return;
		}
		if ( completed === true ) {
			missionSection.textContent = '✔';
		} else {
			missionSection.textContent = '?';
		}
	}, [ completed ] );

	return (
		<>
			<div className="wapuugotchi_missions__map">
				<SVG
					ref={ svgRef }
					xmlns="http://www.w3.org/2000/svg"
					fill="none"
					viewBox="0 0 1207 298"
					dangerouslySetInnerHTML={ { __html: map } }
				></SVG>
			</div>
		</>
	);
}
