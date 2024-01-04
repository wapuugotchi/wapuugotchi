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
			let focus = document.querySelector('.wapuugotchi_onboarding__focus');
			let border = document.querySelector('.wapuugotchi_onboarding__focus_border');

			const targetElement = document.querySelector(pageConfig[index].target);
			requestAnimationFrame(() => {
				focus.style.clipPath = getClipPath(targetElement);
				border.style.clipPath = getClipPathBorder(targetElement);
				border.style.backgroundColor = '#ffcc00ff'
			});
		};
		setFocus();
	}, [index]);

	useEffect(() => {
		const clickPrevent = (action) => {
			let content = document.querySelector('#wpwrap');
			content.addEventListener(action, function(e) {
				e.preventDefault();
				e.stopPropagation();
			}, true);
		}
		clickPrevent('click')
		clickPrevent('dblclick')
	}, []);

	const getClipPath = (target) => {
		const targetRect = target?.getBoundingClientRect();
		let newPosition = 'polygon(0 0, 0 100%, 0 100%, 0 0, 0 0, 0 0, 0 0, 0 100%, 100% 100%, 100% 0)';
		if (targetRect instanceof DOMRect) {
			// set new position
			const path = [
				'0 0',
				'0 100%',
				targetRect.left + 'px' + ' ' + '100%',
				targetRect.left + 'px' + ' ' + targetRect.top + 'px',
				(targetRect.left + targetRect.width) + 'px' + ' ' + targetRect.top + 'px',
				(targetRect.left + targetRect.width) + 'px' + ' ' + (targetRect.top + targetRect.height) + 'px',
				targetRect.left + 'px' + ' ' + (targetRect.top + targetRect.height) + 'px',
				'0 100%',
				'100% 100%',
				'100% 0',
			];
			return 'polygon(' + path.join(', ') + ')';
		}
		return newPosition;
	};
	const getClipPathBorder = (target) => {
		const borderSizeMore = 2
		const targetRect = target?.getBoundingClientRect();
		let newPosition = 'polygon(0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0, 0 0)';
		if (targetRect instanceof DOMRect) {
			// set new position
			const path = [
				(targetRect.left) + 'px' + ' ' + (targetRect.top) + 'px',
				(targetRect.left) + 'px' + ' '+ (targetRect.top + targetRect.height) + 'px',
				targetRect.left + borderSizeMore + 'px' + ' ' + (targetRect.top + targetRect.height) + 'px',
				targetRect.left + borderSizeMore + 'px' + ' ' + (targetRect.top + borderSizeMore) + 'px',
				(targetRect.left + targetRect.width - borderSizeMore) + 'px' + ' ' + (targetRect.top + borderSizeMore) + 'px',
				(targetRect.left + targetRect.width - borderSizeMore) + 'px' + ' ' + (targetRect.top + targetRect.height - borderSizeMore) + 'px',
				targetRect.left + 'px' + ' ' + (targetRect.top + targetRect.height - borderSizeMore) + 'px',
				(targetRect.left) + 'px' + ' ' + (targetRect.top + targetRect.height) + 'px',
				(targetRect.left + targetRect.width) + 'px' + ' ' + (targetRect.top + targetRect.height) + 'px',
				(targetRect.left + targetRect.width) + 'px' + ' ' + (targetRect.top) + 'px',
			];
			return 'polygon(' + path.join(', ') + ')';
		}
		return newPosition;
	};

	return (
		<>
			<div className="wapuugotchi_onboarding__focus">
			</div>
			<div className="wapuugotchi_onboarding__focus_border">
			</div>
		</>
	);
}
