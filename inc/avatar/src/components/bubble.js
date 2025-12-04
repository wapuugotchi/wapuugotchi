import { useCallback, useLayoutEffect, useState } from '@wordpress/element';
import { STORE_NAME } from '../store';
import { useDispatch, useSelect } from '@wordpress/data';
import parse from 'html-react-parser';
import apiFetch from '@wordpress/api-fetch';
import './bubble.scss';

export default function Bubble() {
	const { setMessages } = useDispatch( STORE_NAME );
	const { messages } = useSelect( ( select ) => {
		return {
			messages: select( STORE_NAME ).getMessages(),
		};
	} );
	const [ topOffset, setTopOffset ] = useState( null );

	const handleClickMessage = useCallback( async () => {
		const removedItem = messages.shift();

		await apiFetch( {
			path: `wapuugotchi/v1/dismiss_message`,
			method: 'POST',
			data: {
				id: removedItem?.id,
			},
		} );

		setMessages( messages );
	}, [ messages, setMessages ] );

	const updatePosition = useCallback( () => {
		const container = document.getElementById( 'wapuugotchi__avatar' );
		const target = container?.querySelector( 'div.wapuugotchi__svg > svg > g' );
		const bubble = container?.querySelector( '.wapuugotchi__bubble' );

		if ( ! container || ! target || ! bubble ) {
			return;
		}

		const containerRect = container.getBoundingClientRect();
		const targetRect = target.getBoundingClientRect();
		const bubbleRect = bubble.getBoundingClientRect();
		const offset =
			targetRect.top - containerRect.top - bubbleRect.height - 12;

		setTopOffset( Math.max( 0, offset ) );
	}, [] );

	useLayoutEffect( () => {
		if ( messages.length < 1 ) {
			return undefined;
		}

		updatePosition();
		window.addEventListener( 'resize', updatePosition );

		return () => window.removeEventListener( 'resize', updatePosition );
	}, [ messages.length, updatePosition ] );

	return messages.length > 0 ? (
		<div
			className={ `wapuugotchi__bubble fade_in_lazy ${ messages[ 0 ].type }_bubble` }
			onClick={ handleClickMessage }
			style={ topOffset !== null ? { top: `${ topOffset - 10 }px` } : undefined }
		>
			{ parse( messages[ 0 ].message ) }
		</div>
	) : null;
}
