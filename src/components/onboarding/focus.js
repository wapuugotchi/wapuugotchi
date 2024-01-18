import './focus.scss';
import { dispatch, useSelect } from '@wordpress/data';
import { STORE_NAME } from '../../store/onboarding';
import { useEffect, useState } from '@wordpress/element';

export default function Focus() {
	const { index, animated, pageName, pageConfig, globalConfig } = useSelect((select) => {
		return {
			index: select(STORE_NAME).getIndex(),
			pageName: select(STORE_NAME).getPageName(),
			pageConfig: select(STORE_NAME).getPageConfig(),
			globalConfig: select(STORE_NAME).getGlobalConfig(),
			animated: select(STORE_NAME).getAnimated()
		};
	});

	useEffect(() => {
		setFocus();
	}, [index]);

	useEffect(() => {
		clickPrevent('click')
		clickPrevent('dblclick')
	}, []);

	useEffect(() => {
		if (animated === true) {
			startAnimation();
			dispatch(STORE_NAME).setAnimated(false);
		}
	}, [animated]);

	const startAnimation = () => {
		if ( Array.isArray(pageConfig?.[index]?.targets ) ) {
			let delay = 0;
			pageConfig[index].targets.forEach( (item) => {
				if ( item.active === true ) {
					delay += parseInt( item.delay ?? 0, 10 )
					//
					// //autoscroll
					// const focusElement = document.querySelector(item.focus);
					// if (focusElement !== null) {
					// 	focusElement.scrollIntoView({ behavior: "smooth", block: "center", inline: "nearest" });
					// }

					const focusElement = document.querySelector(item.focus);
					setTimeout( function() {
						let focus = document.querySelector( '.wapuugotchi_onboarding__focus' );
						focus.style.clipPath = getClipPath(focusElement);
						focus.style.backgroundColor = item.color ?? '#ffcc00'

						let overlay = document.querySelector('.wapuugotchi_onboarding__focus_overlay');
						const overlayElement = document.querySelector(item.overlay);
						overlay.style.clipPath = getClipPathOverlay(overlayElement);

						const clickElement = document.querySelector(item.click);
						if ( clickElement instanceof HTMLElement ) {
							clickElement?.classList?.add('wapuugotchi__allow_click')
							clickElement.click()
						}
					}, delay )
				}
			});
		}
	};

	const clickPrevent = (action) => {
		let content = document.querySelector('#wpwrap');
		content.addEventListener(action, function(e) {
			if(e.target.classList.contains('wapuugotchi__allow_click') === false) {
				e.target.classList.remove('wapuugotchi__allow_click')
				e.preventDefault();
				e.stopPropagation();
			}
		}, true);
	}

	const setFocus = () => {
		const target = pageConfig?.[index]?.targets?.[0];
		if ( target?.active === true ) {
			const focusElement = document.querySelector(target.focus);
			let focus = document.querySelector( '.wapuugotchi_onboarding__focus' );
			focus.style.clipPath = getClipPath(focusElement);
			focus.style.backgroundColor = target.color ?? '#ffcc00'

			let overlay = document.querySelector('.wapuugotchi_onboarding__focus_overlay');
			const overlayElement = document.querySelector(target.overlay);
			overlay.style.clipPath = getClipPathOverlay(overlayElement);
		}
	};

	const getClipPathOverlay = (target) => {
		const targetRect = target?.getBoundingClientRect();
		if (targetRect instanceof DOMRect === false) {
			return `polygon(0 0, 0 100%, 0 100%, 0 0, 0 0, 0 0, 0 0, 0 100%, 100% 100%, 100% 0)`;
		}
		return `polygon(
			0 0,
			0 100%,
			${targetRect.left}px 100%,
			${targetRect.left}px ${targetRect.top}px,
			${targetRect.left + targetRect.width}px ${targetRect.top}px,
			${targetRect.left + targetRect.width}px ${targetRect.top + targetRect.height}px,
			${targetRect.left}px ${targetRect.top + targetRect.height}px,
			0 100%,
			100% 100%,
			100% 0
		)`;
	};
	const getClipPath = (target, borderSizeMore = 2) => {
		const targetRect = target?.getBoundingClientRect();
		if (targetRect instanceof DOMRect === false) {
			return `polygon(0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0)`;
		}
		// set new position
		return `polygon(
			${targetRect.left}px ${targetRect.top}px,
			${targetRect.left}px ${targetRect.top + targetRect.height}px,
			${targetRect.left + borderSizeMore}px ${targetRect.top + targetRect.height}px,
			${targetRect.left + borderSizeMore}px ${targetRect.top + borderSizeMore}px,
			${targetRect.left + targetRect.width - borderSizeMore}px ${targetRect.top + borderSizeMore}px,
			${targetRect.left + targetRect.width - borderSizeMore}px ${targetRect.top + targetRect.height - borderSizeMore}px,
			${targetRect.left}px ${targetRect.top + targetRect.height - borderSizeMore}px,
			${targetRect.left}px ${targetRect.top + targetRect.height}px,
			${targetRect.left + targetRect.width}px ${targetRect.top + targetRect.height}px,
			${targetRect.left + targetRect.width}px ${targetRect.top}px
		)`;
	};

	return (
		<>
			<div className="wapuugotchi_onboarding__focus_overlay" />
			<div className="wapuugotchi_onboarding__focus" />
		</>
	);
}
