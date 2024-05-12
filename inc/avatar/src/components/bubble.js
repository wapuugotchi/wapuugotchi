import { useCallback } from '@wordpress/element';
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

	return messages.length > 0 ? (
		<div
			className={ `wapuugotchi__bubble fade_in_lazy ${ messages[ 0 ].type }_bubble` }
			onClick={ handleClickMessage }
		>
			{ parse( messages[ 0 ].message ) }
		</div>
	) : null;
}
