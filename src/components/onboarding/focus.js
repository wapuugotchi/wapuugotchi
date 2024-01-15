import './focus.scss';
import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../../store/onboarding';
import { useEffect, useState } from '@wordpress/element';

export default function Focus() {
	const { index, pageName, pageConfig, globalConfig } = useSelect((select) => {
		return {
			index: select(STORE_NAME).getIndex(),
			pageName: select(STORE_NAME).getPageName(),
			pageConfig: select(STORE_NAME).getPageConfig(),
			globalConfig: select(STORE_NAME).getGlobalConfig(),
		};
	});

	useEffect(() => {
		const setFocus = () => {
			if ( pageConfig?.[index]?.target?.active === true ) {
				let focus = document.querySelector('.wapuugotchi_onboarding__focus');
				const focusElement = document.querySelector(pageConfig[index].target?.focus);
				focus.style.clipPath = getClipPath(focusElement);
				focus.style.backgroundColor = pageConfig[index].target['color'] ?? '#ffcc00'

				let overlay = document.querySelector('.wapuugotchi_onboarding__focus_overlay');
				const overlayElement = pageConfig[index].target?.overlay !== undefined
					? document.querySelector(pageConfig[index].target?.overlay)
					: document.querySelector(pageConfig[index].target?.focus);
				overlay.style.clipPath = getClipPathOverlay(overlayElement);

				if ( pageConfig?.[index]?.click?.active === true ) {
					focusElement?.classList?.add('wapuugotchi__allow_click')

					setTimeout(function() {
						console.log(document.querySelector(pageConfig[index].target?.focus))
						document.querySelector(pageConfig[index].target?.focus).click()
						setTimeout(function() {
							const clickFocusElement = document.querySelector(pageConfig[index].click?.focus);
							const clickOverlayElement = pageConfig[index].click?.overlay !== undefined
								? document.querySelector(pageConfig[index].click?.overlay)
								: document.querySelector(pageConfig[index].click?.focus);
							focus.style.clipPath = getClipPath(clickFocusElement);
							overlay.style.clipPath = getClipPathOverlay(clickOverlayElement);
						}, pageConfig?.[index]?.click?.delay ?? 1000);
					}, 3000);
				}
			}
		};
		setFocus();
	}, [index]);

	useEffect(() => {
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
		clickPrevent('click')
		clickPrevent('dblclick')
	}, []);

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
