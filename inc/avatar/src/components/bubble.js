import { useCallback, useEffect, useState } from '@wordpress/element';
import { STORE_NAME } from '../store';
import { useDispatch, useSelect } from '@wordpress/data';
import parse from 'html-react-parser';
import apiFetch from '@wordpress/api-fetch';
import './bubble.scss';

export default function Bubble() {
	const { setMessages } = useDispatch( STORE_NAME );
	const { messages, avatar } = useSelect( ( select ) => {
		return {
			messages: select( STORE_NAME ).getMessages(),
			avatar: select( STORE_NAME ).getAvatar(),
		};
	} );
	const [ bottomOffset, setBottomOffset ] = useState( null );

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

	useEffect( () => {
		if ( messages.length < 1 ) {
			setBottomOffset( null );
			return;
		}

		let animFrame;

		const updatePosition = () => {
			const container = document.getElementById( 'wapuugotchi__avatar' );
			const svg = container?.querySelector( '.wapuugotchi__svg' );
			const target = container?.querySelector(
				'g#wapuugotchi_type__wapuu, g#wapuugotchi_type__bear, g#wapuugotchi_type__rabbit, g#wapuugotchi_type__squirrel'
			);

			if ( ! target || ! svg ) {
				animFrame = requestAnimationFrame( updatePosition );
				return;
			}

			const prevState = target.style.animationPlayState;
			target.style.animationPlayState = 'paused';

			const targetRect = target.getBoundingClientRect();
			const svgRect = svg.getBoundingClientRect();

			target.style.animationPlayState = prevState;

			if ( targetRect.height === 0 ) {
				animFrame = requestAnimationFrame( updatePosition );
				return;
			}

			const offset = ( window.innerHeight - document.body.clientHeight ) - ( targetRect.top - svgRect.top );
			setBottomOffset( offset );
		};

		animFrame = requestAnimationFrame( updatePosition );
		window.addEventListener( 'resize', updatePosition );

		return () => {
			cancelAnimationFrame( animFrame );
			window.removeEventListener( 'resize', updatePosition );
		};
	}, [ messages.length, avatar ] );

	return messages.length > 0 ? (
		<div
			className={ `wapuugotchi__bubble fade_in_lazy ${ messages[ 0 ].type }_bubble` }
			onClick={ handleClickMessage }
			style={
				bottomOffset !== null
					? { bottom: `${ bottomOffset }px` }
					: { visibility: 'hidden' }
			}
		>
			{ parse( messages[ 0 ].message ) }
		</div>
	) : null;
}
