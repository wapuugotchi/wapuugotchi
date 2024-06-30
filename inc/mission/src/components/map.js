import './map.scss';
import { useEffect, useRef } from '@wordpress/element';
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../store";
import { SVG } from '@wordpress/primitives';

export default function Map() {

	const { map } = useSelect( ( select ) => {
		return {
			map: select( STORE_NAME ).getMap(),
		};
	} );

	const svgRef = useRef(null);

	useEffect(() => {
		const svgElement = svgRef.current;
		if (!svgElement) return;

		const missionSection = svgElement.querySelector('#mission_section');
		if (!missionSection) return;

		const showAcion = (event) => {
			if (event.target.parentNode === missionSection) {
				const action = document.querySelector('#wapuugotchi_mission__action');
				action.style.display = 'block';
				action.classList.add('zoomIn');
			}
		};

		svgElement?.addEventListener('click', showAcion);

		// Clean up on unmount
		return () => {
			svgElement?.removeEventListener('click', showAcion);
		};
	}, [svgRef]);

	return (
		<>
			<div className="wapuugotchi_missions__map">
				<SVG
					ref={svgRef}
					xmlns="http://www.w3.org/2000/svg"
					 fill="none"
					 viewBox="0 0 1207 298"
					 dangerouslySetInnerHTML={{__html: map}}
				>
				</SVG>
			</div>
		</>
	);
}
