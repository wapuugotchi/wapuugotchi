import './map.scss';
import { useEffect, useRef } from '@wordpress/element';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { SVG } from '@wordpress/primitives';
import Schloss from './assets/schloss.svg';
import { _n, sprintf } from '@wordpress/i18n';

function createCooldown( hours, className ) {
	const cooldown = document.createElement( 'div' );
	cooldown.classList.add( className );

	const img = document.createElement( 'img' );
	img.src = Schloss;
	img.alt = 'Schloss';
	img.style.width = '24px';
	img.style.verticalAlign = 'middle';

	const text = document.createElement( 'p' );
	text.textContent = sprintf(
		// translators: %d: Anzahl der Stunden
		_n( '%d hour left', '%d hours left', hours, 'wapuugotchi' ),
		hours
	);

	cooldown.appendChild( img );
	cooldown.appendChild( text );

	return cooldown;
}

export default function Map() {
	const { map, completed, progress, cooldown } = useSelect( ( select ) => {
		return {
			map: select( STORE_NAME ).getMap(),
			completed: select( STORE_NAME ).getCompleted(),
			progress: select( STORE_NAME ).getProgress(),
			cooldown: select( STORE_NAME ).getCooldown(),
		};
	} );

	const svgRef = useRef( null );

	useEffect( () => {
		const svgElement = svgRef.current;
		if ( ! svgElement ) {
			return;
		}

		const missionSection = svgElement.querySelector(
			'#mission_section text.active'
		);

		const highlightsTarget = ! missionSection ? progress : progress + 1;
		const highlights = svgElement.querySelectorAll(
			'[class*="visible-at-progress_"]'
		);
		highlights.forEach( ( highlight ) => {
			if (
				highlight.classList.contains(
					`visible-at-progress_${ highlightsTarget }`
				)
			) {
				highlight.style.opacity = 'var(--active-oc)';
				highlight.style.fill = 'var(--highlight)';
			} else {
				highlight.style.opacity = 'var(--inactive-oc)';
			}
		} );
	}, [] );

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

		const cooldownClass = 'cooldownTimer';
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

		if ( ! missionSection && allMissions[ progress - 1 ] ) {
			allMissions[ progress - 1 ].textContent = '✔';
			allMissions[ progress - 1 ].style.fill = '#009900';
			allMissions[ progress - 1 ].style.opacity = 1;
			allMissions[ progress - 1 ].style.fontSize = '50px';

			const parent = svgElement.parentElement;
			if ( ! parent.querySelector( '.' + cooldownClass ) ) {
				parent.appendChild( createCooldown( cooldown, cooldownClass ) );
			}
		} else if ( completed === true ) {
			missionSection.textContent = '✔';
			missionSection.style.fill = '#009900';
			missionSection.style.opacity = 1;
			missionSection.style.fontSize = '50px';
			missionSection.classList.add( 'completed' );
			missionSection.classList.remove( 'active' );
			const parent = svgElement.parentElement;
			if ( ! parent.querySelector( '.' + cooldownClass ) ) {
				parent.appendChild( createCooldown( cooldown, cooldownClass ) );
			}
		} else {
			missionSection.textContent = '';
			missionSection.style.fill = 'var(--marker-start-color)';
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
