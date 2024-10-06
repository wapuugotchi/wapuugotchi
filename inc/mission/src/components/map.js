import './map.scss';
import { useEffect, useRef } from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { SVG } from '@wordpress/primitives';

export default function Map() {
	const { map, completed, progress } = useSelect( ( select ) => {
		return {
			map: select( STORE_NAME ).getMap(),
			completed: select( STORE_NAME ).getCompleted(),
			progress: select( STORE_NAME ).getProgress(),
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

		const allMissions = svgElement.querySelectorAll(
			'#mission_section text'
		);

		const missionSection = svgElement.querySelector(
			'#mission_section text.active'
		);

		for ( let x = 0; x < progress; x++ ) {
			allMissions[ x ].textContent = '✔';
			allMissions[ x ].style.fill = '#A9A9A9';
			allMissions[ x ].style.opacity = 0.6;
			allMissions[ x ].style.fontSize = '35px';
		}

		if ( ! missionSection ) {
			if ( allMissions[ progress - 1 ] ) {
				allMissions[ progress - 1 ].textContent = '✔';
				allMissions[ progress - 1 ].style.fill = '#009900';
				allMissions[ progress - 1 ].style.opacity = 1;
				allMissions[ progress - 1 ].style.fontSize = '50px';
			}
		} else if ( completed === true ) {
			missionSection.textContent = '✔';
			missionSection.style.fill = '#009900';
			missionSection.style.opacity = 1;
			missionSection.style.fontSize = '50px';
			missionSection.classList.add( 'completed' );
		} else {
			missionSection.textContent = '';
			missionSection.style.fill = '#009900';
			missionSection.style.opacity = 1;
			missionSection.style.fontSize = '50px';
		}
	}, [ completed, progress ] );

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
