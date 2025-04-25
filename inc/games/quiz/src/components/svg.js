import { useDispatch, useSelect, useRegistry } from '@wordpress/data';
import { useState, useEffect, useCallback } from '@wordpress/element';
import { appendTagsToElement } from '../utils/textUtils';
import './svg.scss';
import { STORE_NAME } from '../store';

/**
 * The Svg component. It renders the avatar SVG with the quiz data.
 *
 * @return {Object} The rendered component.
 */
export default function Svg() {
	const registry = useRegistry();
	const { setCompleted, setData, setAvatar } = useDispatch( STORE_NAME );
	const { avatar, quiz, data } = useSelect( ( select ) => ( {
		avatar: select( STORE_NAME ).getAvatar(),
		quiz: select( STORE_NAME ).getQuiz(),
		data: select( STORE_NAME ).getData(),
	} ) );

	const [ completed, setCompletedState ] = useState( false );
	const [ wrong, setWrong ] = useState( false );

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
	 * Event handler for overlay click. Removes specific groups from the SVG and updates the state.
	 *
	 * @param {Event} event - The click event.
	 */
	const handleOverlayClick = useCallback(
		( event ) => {
			if (
				event.target.classList.contains(
					'wapuugotchi_mission__overlay'
				)
			) {
				const avatarElement = document.querySelector(
					'#wapuugotchi_quiz__svg'
				);
				avatarElement.querySelector( 'g#Cloud--group' )?.remove();
				avatarElement.querySelector( 'g#TextBox--group' )?.remove();

				if ( wrong ) {
					data.shift();
				}

				registry.batch( () => {
					setAvatar( avatarElement.outerHTML );
					setData( data );
					setWrong( false );
				} );
			}
		},
		[ data, wrong, registry, setAvatar, setData ]
	);

	/**
	 * Event handler for cloud click. Updates the text box based on the clicked cloud's index.
	 *
	 * @param {number} index - The index of the clicked cloud.
	 */
	const handleCloudClick = useCallback(
		( index ) => {
			const clouds = document.querySelector(
				'#wapuugotchi_quiz__svg g#Cloud--group'
			);
			const textBox = document.querySelector(
				'#wapuugotchi_quiz__svg g#TextBox--group text'
			);

			clouds?.remove();
			textBox
				.querySelectorAll( 'tspan' )
				.forEach( ( tspan ) => tspan.remove() );

			if ( index === quiz.position ) {
				textBox.setAttribute( 'fill', '#090' );
				appendTagsToElement( textBox, quiz.agreement, 155 );
				setCompletedState( true );
			} else {
				textBox.setAttribute( 'fill', '#900' );
				appendTagsToElement( textBox, quiz.disagreement, 155 );
				setWrong( true );
			}
		},
		[ quiz ]
	);

	/**
	 * Event handler for SVG click. Forwards the click event to the overlay.
	 *
	 * @param {Event} event - The click event.
	 */
	const handleSvgClick = useCallback( ( event ) => {
		if ( event.target.id !== 'wapuugotchi_quiz__svg' ) {
			return;
		}
		const overlay = document.querySelector(
			'.wapuugotchi_mission__overlay'
		);
		if ( overlay ) {
			overlay.click();
		}
	}, [] );

	/**
	 * Effect hook to add and remove the overlay click event listener.
	 */
	useEffect( () => {
		const overlay = document.querySelector(
			'.wapuugotchi_mission__overlay'
		);
		const action = document.querySelector( '.wapuugotchi_mission__action' );

		overlay.addEventListener( 'click', handleOverlayClick );
		action.addEventListener( 'click', function ( event ) {
			if (
				event.target.classList.contains( 'wapuugotchi_mission__action' )
			) {
				event.stopPropagation();
				overlay.click();
			}
		} );

		return () => {
			overlay.removeEventListener( 'click', handleOverlayClick );
		};
	}, [ handleOverlayClick ] );

	/**
	 * Effect hook to add and remove the cloud click event listeners.
	 */
	useEffect( () => {
		const clouds = document.querySelector(
			'#wapuugotchi_quiz__svg g#Cloud--group'
		);
		clouds.querySelectorAll( 'g.cloud' ).forEach( ( cloud, index ) => {
			cloud.addEventListener( 'click', () => handleCloudClick( index ) );
		} );

		setCompletedState( false );
	}, [ quiz, handleCloudClick ] );

	/**
	 * Effect hook to add and remove the SVG click event listener.
	 */
	useEffect( () => {
		const svgElement = document.querySelector( '#wapuugotchi_quiz__svg' );
		svgElement.addEventListener( 'click', handleSvgClick );

		return () => {
			svgElement.removeEventListener( 'click', handleSvgClick );
		};
	}, [ handleSvgClick ] );

	/**
	 * Effect hook to set the completed state.
	 */
	useEffect( () => {
		if ( completed ) {
			setCompleted();
		}
	}, [ completed, setCompleted ] );

	return (
		<div className="wapuugotchi_mission__action">
			<svg
				id="wapuugotchi_quiz__svg"
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
