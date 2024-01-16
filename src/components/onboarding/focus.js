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
			if ( Array.isArray(pageConfig?.[index]?.targets ) ) {
				let delay = 0;
				pageConfig[index].targets.forEach((item) => {
					if ( item.active === true ) {
						delay += parseInt( item.delay ?? 0, 10 )
						setTimeout( function() {
							let focus = document.querySelector( '.wapuugotchi_onboarding__focus' );
							const focusElement = document.querySelector(item.focus);
							focus.style.clipPath = getClipPath(focusElement);
							focus.style.backgroundColor = item.color ?? '#ffcc00'

							let overlay = document.querySelector('.wapuugotchi_onboarding__focus_overlay');
							const overlayElement = document.querySelector(item.overlay);
							overlay.style.clipPath = getClipPathOverlay(overlayElement);

							const clickElement = document.querySelector(item.click);
							if ( clickElement instanceof HTMLElement ) {
								focusElement?.classList?.add('wapuugotchi__allow_click')
								clickElement.click();
							}
						}, delay )
					}
				});
			}

			handleLoader();
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

	const handleLoader = () => {
		// Loader handling
		let loader = document.querySelector('.wapuugotchi_onboarding__loader');
		let nextButton = document.querySelector('button.wapuugotchi_onboarding__navigation_next span');
		let lastButton = document.querySelector('button.wapuugotchi_onboarding__navigation_last span');
		if ( Number.isInteger(pageConfig?.[index]?.freeze) && pageConfig?.[index]?.freeze > 0) {
			//show loader and disable next and last button
			loader.style.display = 'block';
			nextButton.classList.add('disabled')
			lastButton.classList.add('disabled')
			setTimeout(function() {
				//hide loader and enable next and last button
				loader.style.display = 'none';
				nextButton.classList.remove('disabled')
				lastButton.classList.remove('disabled')
			}, pageConfig[index].freeze);
		}
	}

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
