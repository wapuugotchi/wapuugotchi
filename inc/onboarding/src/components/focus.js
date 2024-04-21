import './focus.scss';
import { dispatch, useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';
import { useEffect } from '@wordpress/element';

export default function Focus() {
	const { index, animated, pageConfig } = useSelect( ( select ) => {
		return {
			index: select( STORE_NAME ).getIndex(),
			pageConfig: select( STORE_NAME ).getPageConfig(),
			animated: select( STORE_NAME ).getAnimated(),
		};
	} );

	/**
	 * Focus handler.
	 * If animated is true, get all elements and focus them one after the other.
	 * If animated is false, get first element and focus it.
	 */
	useEffect( () => {
		const handleItem = ( item ) => {
			const focus = document.querySelector(
				'.wapuugotchi_onboarding__focus'
			);
			const focusElement = document.querySelector( item.focus );
			focus.style.clipPath = getClipPathFocus( focusElement );
			focus.style.backgroundColor = item.color ?? '#ffcc00';

			const overlay = document.querySelector(
				'.wapuugotchi_onboarding__focus_overlay'
			);
			const overlayElement = document.querySelector( item.overlay );
			overlay.style.clipPath = getClipPathOverlay( overlayElement );

			const clickElement = document.querySelector( item.click );
			if ( clickElement instanceof HTMLElement ) {
				clickElement?.classList?.add( 'wapuugotchi__allow_click' );
				clickElement.click();
			}
		};

		if ( animated === true ) {
			// If animated is true, get all elements and focus them one after the other.
			if ( Array.isArray( pageConfig?.[ index ]?.target_list ) ) {
				let delay = 0;
				pageConfig[ index ].target_list.forEach( ( item ) => {
					if ( item.active === true ) {
						delay += parseInt( item.delay ?? 0, 10 );
						setTimeout( function () {
							handleItem( item );
						}, delay );
					}
				} );
			}
			dispatch( STORE_NAME ).setAnimated( false );
		} else {
			// If animated is false, get first element and focus it.
			const item = pageConfig?.[ index ]?.target_list?.[ 0 ];
			if ( item?.active === true ) {
				handleItem( item );
			}
		}
	}, [ index, animated, pageConfig ] );

	useEffect( () => {
		clickPrevent( 'click' );
		clickPrevent( 'dblclick' );
	}, [] );

	const clickPrevent = ( action ) => {
		const content = document.querySelector( '#wpwrap' );
		content.addEventListener(
			action,
			function ( e ) {
				if (
					e.target.classList.contains(
						'wapuugotchi__allow_click'
					) === false
				) {
					e.target.classList.remove( 'wapuugotchi__allow_click' );
					e.preventDefault();
					e.stopPropagation();
				}
			},
			true
		);
	};

	const getClipPathOverlay = ( target ) => {
		let targetRect = target?.getBoundingClientRect();

		// if target is not found, use defaults
		if ( targetRect instanceof DOMRect === false ) {
			const defaultRect = document
				?.querySelector( '#Onboarding--group' )
				?.getBoundingClientRect();
			if ( defaultRect instanceof DOMRect === true ) {
				targetRect = defaultRect;
			} else {
				return `polygon(0 0, 0 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 100% 100%, 100% 0)`;
			}
		}

		return `polygon(
			0 0,
			0 100%,
			${ targetRect.left }px 100%,
			${ targetRect.left }px ${ targetRect.top }px,
			${ targetRect.left + targetRect.width }px ${ targetRect.top }px,
			${ targetRect.left + targetRect.width }px ${
				targetRect.top + targetRect.height
			}px,
			${ targetRect.left }px ${ targetRect.top + targetRect.height }px,
			0 100%,
			100% 100%,
			100% 0
		)`;
	};
	const getClipPathFocus = ( target, borderSizeMore = 2 ) => {
		let targetRect = target?.getBoundingClientRect();

		// if target is not found, use defaults
		if ( targetRect instanceof DOMRect === false ) {
			const defaultRect = document
				?.querySelector( '#Onboarding--group' )
				?.getBoundingClientRect();
			if ( defaultRect instanceof DOMRect === true ) {
				targetRect = defaultRect;
			} else {
				return `polygon(50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%, 50% 100%)`;
			}
		}

		// set new position
		return `polygon(
			${ targetRect.left }px ${ targetRect.top }px,
			${ targetRect.left }px ${ targetRect.top + targetRect.height }px,
			${ targetRect.left + borderSizeMore }px ${
				targetRect.top + targetRect.height
			}px,
			${ targetRect.left + borderSizeMore }px ${ targetRect.top + borderSizeMore }px,
			${ targetRect.left + targetRect.width - borderSizeMore }px ${
				targetRect.top + borderSizeMore
			}px,
			${ targetRect.left + targetRect.width - borderSizeMore }px ${
				targetRect.top + targetRect.height - borderSizeMore
			}px,
			${ targetRect.left }px ${
				targetRect.top + targetRect.height - borderSizeMore
			}px,
			${ targetRect.left }px ${ targetRect.top + targetRect.height }px,
			${ targetRect.left + targetRect.width }px ${
				targetRect.top + targetRect.height
			}px,
			${ targetRect.left + targetRect.width }px ${ targetRect.top }px
		)`;
	};

	return (
		<>
			<div className="wapuugotchi_onboarding__focus_overlay" />
			<div className="wapuugotchi_onboarding__focus" />
		</>
	);
}
