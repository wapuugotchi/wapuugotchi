import { useSelect } from '@wordpress/data';
import { useCallback, useEffect } from '@wordpress/element';
import apiFetch from '@wordpress/api-fetch';
import './svg.scss';
import { STORE_NAME } from '../store';

/**
 * The Svg component. It renders the avatar SVG with the hunt data.
 *
 * @return {Object} The rendered component.
 */
export default function Svg() {
	const { avatar, data, nonces } = useSelect( ( select ) => ( {
		avatar: select( STORE_NAME ).getAvatar(),
		data: select( STORE_NAME ).getData(),
		nonces: select( STORE_NAME ).getNonces(),
	} ) );

	/**
	 * Prepares the SVG string by parsing it into an SVG element and returning its inner HTML.
	 *
	 * @param {string} svgString - The SVG string to be parsed.
	 * @return {string} The inner HTML of the parsed SVG element.
	 */
	const prepareSvg = useCallback( ( svgString ) => {
		const parser = new DOMParser();
		const doc = parser.parseFromString( svgString, 'image/svg+xml' );
		return doc.querySelector( 'svg' ).innerHTML;
	}, [] );

	/**
	 * Effect hook to add and remove the overlay click event listener.
	 */
	useEffect( () => {
		const overlay = document.querySelector(
			'.wapuugotchi_mission__overlay'
		);
		const action = document.querySelector( '.wapuugotchi_mission__action' );

		action.addEventListener( 'click', function ( event ) {
			if (
				event.target.classList.contains( 'wapuugotchi_mission__action' )
			) {
				event.stopPropagation();
				overlay.click();
			}
		} );
	}, [] );

	useEffect(() => {
		const mission = document.querySelector('#mission_section');
		mission.addEventListener('click', async () => {
			// activate mission!!
			console.log('Mission activated!');

			await apiFetch({
				path: 'wapuugotchi/v1/hunt/start_mission',
				method: 'POST',
				data: {
					id: data.id,
					nonce: nonces?.wapuugotchi_hunt,
				},
			}).then((response) => {
				console.log(response);
			});

		});
	}, []);

	return (
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
	);
}
