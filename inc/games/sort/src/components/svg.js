import { useDispatch, useSelect, useRegistry } from '@wordpress/data';
import { useState, useEffect, useCallback, useRef } from '@wordpress/element';
import { appendTagsToElement } from '../utils/textUtils';
import './svg.scss';
import { STORE_NAME } from '../store';
import { CARD_POSITIONS } from '../utils/cardUtils';
import { SLOT_POSITIONS } from '../utils/slotUtils';
import { TEXT_CENTER_X } from '../utils/boxUtils';

const SVG_ID = '#wapuugotchi_sort__svg';

/**
 * Converts a pointer client position to SVG coordinate space.
 *
 * @param {SVGSVGElement} svgEl   - The SVG root element.
 * @param {number}        clientX - The client X coordinate.
 * @param {number}        clientY - The client Y coordinate.
 * @return {{x: number, y: number}} The SVG-space coordinates.
 */
const clientToSvg = ( svgEl, clientX, clientY ) => {
	const pt = svgEl.createSVGPoint();
	pt.x = clientX;
	pt.y = clientY;
	return pt.matrixTransform( svgEl.getScreenCTM().inverse() );
};

/**
 * Returns the card element with a given data-card-index attribute.
 *
 * @param {number} cardIndex - The card index to find.
 * @return {Element|null} The matching card element.
 */
const getCardEl = ( cardIndex ) =>
	document.querySelector(
		`${ SVG_ID } g#Card--group g.card[data-card-index="${ cardIndex }"]`
	);

/**
 * The Svg component. Renders the avatar SVG with drag-and-drop sort challenge.
 *
 * @return {Object} The rendered component.
 */
export default function Svg() {
	const registry = useRegistry();
	const { setCompleted, setData, setAvatar } = useDispatch( STORE_NAME );
	const { avatar, sort, data } = useSelect( ( select ) => ( {
		avatar: select( STORE_NAME ).getAvatar(),
		sort: select( STORE_NAME ).getSort(),
		data: select( STORE_NAME ).getData(),
	} ) );

	const [ completed, setCompletedState ] = useState( false );
	const [ wrong, setWrong ] = useState( false );
	const dragRef = useRef( { active: false } );
	const slottedRef = useRef( [ null, null, null ] );

	/**
	 * Prepares the SVG string by parsing it and returning its inner HTML.
	 *
	 * @param {string} svgString - The SVG string to parse.
	 * @return {string} The inner HTML of the parsed SVG.
	 */
	const prepareSvg = useCallback( ( svgString ) => {
		const parser = new DOMParser();
		const doc = parser.parseFromString( svgString, 'image/svg+xml' );
		return doc.querySelector( 'svg' ).innerHTML;
	}, [] );

	/**
	 * Evaluates the current slot assignments and shows the result.
	 */
	const evaluateAnswer = useCallback( () => {
		const isCorrect = slottedRef.current.every(
			( cardIdx, pos ) => sort.items[ cardIdx ] === sort.correct_order[ pos ]
		);

		document.querySelector( `${ SVG_ID } g#Card--group` )?.remove();
		document.querySelector( `${ SVG_ID } g#Slot--group` )?.remove();

		const textBox = document.querySelector(
			`${ SVG_ID } g#TextBox--group text`
		);
		textBox.querySelectorAll( 'tspan' ).forEach( ( t ) => t.remove() );

		if ( isCorrect ) {
			textBox.setAttribute( 'fill', '#090' );
			appendTagsToElement( textBox, sort.agreement, TEXT_CENTER_X );
			setCompletedState( true );
		} else {
			textBox.setAttribute( 'fill', '#900' );
			appendTagsToElement( textBox, sort.disagreement, TEXT_CENTER_X );
			setWrong( true );
		}
	}, [ sort ] );

	/**
	 * Handles pointer down on the SVG. Starts a drag if a card was targeted.
	 *
	 * @param {PointerEvent} event - The pointer event.
	 */
	const handlePointerDown = useCallback( ( event ) => {
		const card = event.target.closest( 'g.card' );
		if ( ! card ) {
			return;
		}

		event.preventDefault();
		const svgEl = document.querySelector( SVG_ID );
		svgEl.setPointerCapture( event.pointerId );

		const cardIndex = parseInt( card.getAttribute( 'data-card-index' ), 10 );
		const svgPt = clientToSvg( svgEl, event.clientX, event.clientY );
		const [ , ox, oy ] = card
			.getAttribute( 'transform' )
			.match( /translate\(([\d.-]+),\s*([\d.-]+)\)/ );

		dragRef.current = {
			active: true,
			cardIndex,
			cardEl: card,
			origX: parseFloat( ox ),
			origY: parseFloat( oy ),
			startX: svgPt.x,
			startY: svgPt.y,
		};

		card.setAttribute( 'style', 'cursor: grabbing; opacity: 0.8;' );
		// Bring card to front within its parent group.
		card.parentElement?.appendChild( card );
	}, [] );

	/**
	 * Handles pointer move: updates the dragged card position.
	 *
	 * @param {PointerEvent} event - The pointer event.
	 */
	const handlePointerMove = useCallback( ( event ) => {
		const { active, cardEl, origX, origY, startX, startY } = dragRef.current;
		if ( ! active ) {
			return;
		}

		const svgEl = document.querySelector( SVG_ID );
		const { x, y } = clientToSvg( svgEl, event.clientX, event.clientY );
		cardEl.setAttribute(
			'transform',
			`translate(${ origX + x - startX }, ${ origY + y - startY })`
		);
	}, [] );

	/**
	 * Handles pointer up: snaps card to nearest slot or returns it home.
	 */
	const handlePointerUp = useCallback( () => {
		const { active, cardEl, cardIndex } = dragRef.current;
		if ( ! active ) {
			return;
		}
		dragRef.current.active = false;
		cardEl.setAttribute( 'style', 'cursor: grab;' );

		// Compute current card center in SVG coordinates.
		const [ , cx, cy ] = cardEl
			.getAttribute( 'transform' )
			.match( /translate\(([\d.-]+),\s*([\d.-]+)\)/ );
		const centerX = parseFloat( cx ) + 125;
		const centerY = parseFloat( cy ) + 45;

		// Find the nearest slot within the snap threshold.
		const SNAP_THRESHOLD = 150;
		let nearSlot = -1;
		let nearDist = SNAP_THRESHOLD;
		SLOT_POSITIONS.forEach( ( { x, y }, i ) => {
			const d = Math.hypot( centerX - ( x + 125 ), centerY - ( y + 45 ) );
			if ( d < nearDist ) {
				nearDist = d;
				nearSlot = i;
			}
		} );

		if ( nearSlot >= 0 ) {
			// Displace the card already in the target slot, if any.
			const displaced = slottedRef.current[ nearSlot ];
			if ( displaced !== null && displaced !== cardIndex ) {
				const displacedEl = getCardEl( displaced );
				displacedEl?.setAttribute(
					'transform',
					`translate(${ CARD_POSITIONS[ displaced ].x }, ${ CARD_POSITIONS[ displaced ].y })`
				);
				slottedRef.current[ nearSlot ] = null;
			}

			// Free any previous slot this card occupied.
			slottedRef.current = slottedRef.current.map( ( idx ) =>
				idx === cardIndex ? null : idx
			);

			// Snap card to slot.
			cardEl.setAttribute(
				'transform',
				`translate(${ SLOT_POSITIONS[ nearSlot ].x }, ${ SLOT_POSITIONS[ nearSlot ].y })`
			);
			slottedRef.current[ nearSlot ] = cardIndex;

			if ( slottedRef.current.every( ( idx ) => idx !== null ) ) {
				evaluateAnswer();
			}
		} else {
			// Return card to its home position.
			slottedRef.current = slottedRef.current.map( ( idx ) =>
				idx === cardIndex ? null : idx
			);
			cardEl.setAttribute(
				'transform',
				`translate(${ CARD_POSITIONS[ cardIndex ].x }, ${ CARD_POSITIONS[ cardIndex ].y })`
			);
		}
	}, [ evaluateAnswer ] );

	/**
	 * Handles overlay click to reset state and load the next challenge.
	 *
	 * @param {Event} event - The click event.
	 */
	const handleOverlayClick = useCallback(
		( event ) => {
			if (
				! event.target.classList.contains( 'wapuugotchi_mission__overlay' )
			) {
				return;
			}

			const avatarElement = document.querySelector( SVG_ID );
			avatarElement.querySelector( 'g#Card--group' )?.remove();
			avatarElement.querySelector( 'g#Slot--group' )?.remove();
			avatarElement.querySelector( 'g#TextBox--group' )?.remove();

			if ( wrong ) {
				data.shift();
			}

			slottedRef.current = [ null, null, null ];

			registry.batch( () => {
				setAvatar( avatarElement.outerHTML );
				setData( data );
				setWrong( false );
			} );
		},
		[ data, wrong, registry, setAvatar, setData ]
	);

	/**
	 * Handles SVG background click to forward to the overlay.
	 *
	 * @param {Event} event - The click event.
	 */
	const handleSvgClick = useCallback( ( event ) => {
		if ( event.target.id !== 'wapuugotchi_sort__svg' ) {
			return;
		}
		document.querySelector( '.wapuugotchi_mission__overlay' )?.click();
	}, [] );

	/**
	 * Effect: registers overlay and action button click handlers.
	 */
	useEffect( () => {
		const overlay = document.querySelector( '.wapuugotchi_mission__overlay' );
		const action = document.querySelector( '.wapuugotchi_mission__action' );

		overlay.addEventListener( 'click', handleOverlayClick );
		action.addEventListener( 'click', ( e ) => {
			if ( e.target.classList.contains( 'wapuugotchi_mission__action' ) ) {
				e.stopPropagation();
				overlay.click();
			}
		} );

		return () => overlay.removeEventListener( 'click', handleOverlayClick );
	}, [ handleOverlayClick ] );

	/**
	 * Effect: registers drag pointer events on the SVG and resets slot state.
	 */
	useEffect( () => {
		const svgEl = document.querySelector( SVG_ID );

		svgEl.addEventListener( 'pointerdown', handlePointerDown );
		svgEl.addEventListener( 'pointermove', handlePointerMove );
		svgEl.addEventListener( 'pointerup', handlePointerUp );

		slottedRef.current = [ null, null, null ];
		setCompletedState( false );

		return () => {
			svgEl.removeEventListener( 'pointerdown', handlePointerDown );
			svgEl.removeEventListener( 'pointermove', handlePointerMove );
			svgEl.removeEventListener( 'pointerup', handlePointerUp );
		};
	}, [ sort, handlePointerDown, handlePointerMove, handlePointerUp ] );

	/**
	 * Effect: registers SVG background click handler.
	 */
	useEffect( () => {
		const svgEl = document.querySelector( SVG_ID );
		svgEl.addEventListener( 'click', handleSvgClick );
		return () => svgEl.removeEventListener( 'click', handleSvgClick );
	}, [ handleSvgClick ] );

	/**
	 * Effect: triggers mission completion when challenge is answered correctly.
	 */
	useEffect( () => {
		if ( completed ) {
			setCompleted();
		}
	}, [ completed, setCompleted ] );

	return (
		<div className="wapuugotchi_mission__action">
			<svg
				id="wapuugotchi_sort__svg"
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
