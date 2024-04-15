import { useSelect, dispatch } from '@wordpress/data';
import parse from 'html-react-parser';
import apiFetch from '@wordpress/api-fetch';
import { STORE_NAME } from '../store';
import './bubble.scss';

export default function Bubble() {
	const { messages } = useSelect( ( select ) => {
		return {
			messages: select( STORE_NAME ).getMessages(),
		};
	} );
	const handleClickMessage = async () => {
		const removedItem = messages.shift();

		await apiFetch( {
			path: `wapuugotchi/v1/submit_message`,
			method: 'POST',
			data: {
				id: removedItem?.id
			},
		} ).then( ( response ) => { console.log( response ) } );


		dispatch( STORE_NAME ).setMessages( messages );

	};

	return messages.length > 0 ? (
		<div
			className={`wapuugotchi__bubble fade_in_lazy ${messages[0].type}_bubble`}
			onClick={handleClickMessage}
		>
			{parse(messages[0].message)}
		</div>
	) : null;
}
