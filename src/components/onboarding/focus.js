import './focus.scss';
import { useSelect} from "@wordpress/data";
import {STORE_NAME} from "../../store/onboarding";
import {useEffect, useState} from "@wordpress/element";

export default function Focus() {
	const [ position, setPosition ] = useState( { 'top': '0px', 'left': '0px', 'height': '0px', 'width': '0px' } );
	const { index, pageName, pageConfig, globalConfig } = useSelect( ( select ) => {
		return {
			index: select( STORE_NAME ).getIndex(),
			pageName: select( STORE_NAME ).getPageName(),
			pageConfig: select( STORE_NAME ).getPageConfig(),
			globalConfig: select( STORE_NAME ).getGlobalConfig(),
		};
	} );

	useEffect(() => {
		const setFocus = () => {
			let focus = document.querySelector('.wapuugotchi_onboarding__focus')
			let newPosition = {}

			// focus old position
			focus.style.top = position.top
			focus.style.left = position.left
			focus.style.height = position.height
			focus.style.width = position.width
			focus.style.borderWidth = newPosition.borderWidth;

			// calculate new position
			if( pageConfig?.[index]?.target && focus ) {
				let targetRect = document.querySelector(pageConfig[index].target)?.getBoundingClientRect()
				if ( targetRect && pageConfig?.[index]?.target !== null ) {
					newPosition.top = targetRect.top + 'px'
					newPosition.left = targetRect.left + 'px'
					newPosition.height = targetRect.height - 10 + 'px'
					newPosition.width = targetRect.width - 10 + 'px'
					newPosition.borderWidth = '5px';
				}
			}
			else if( pageConfig?.[index]?.target === null && focus ) {
				newPosition.top = '0px'
				newPosition.left = '0px'
				newPosition.height = '0px'
				newPosition.width = '0px'
				newPosition.borderWidth = '0px';
			}

			requestAnimationFrame( () => {
				focus.style.top = newPosition.top
				focus.style.left = newPosition.left
				focus.style.height = newPosition.height
				focus.style.width = newPosition.width
				focus.style.borderWidth = newPosition.borderWidth;
			});

			//store old position.
			setPosition({ ...position,
				'top': newPosition.top,
				'left': newPosition.left,
				'height': newPosition.height,
				'width': newPosition.width,
				'borderWidth': newPosition.borderWidth
			});
		}
		setFocus()
	}, [index]);
	return (
		<>
			<div className="wapuugotchi_onboarding__focus"></div>
		</>
	);
}
