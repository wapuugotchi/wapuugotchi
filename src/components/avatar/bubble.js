import { useSelect, dispatch } from '@wordpress/data';
import parse from 'html-react-parser';
import apiFetch from '@wordpress/api-fetch';
import { STORE_NAME } from '../../store/wapuu';
import './bubble.scss';

export default function Bubble() {
	const { restBase, message } = useSelect( ( select ) => {
		return {
			restBase: select( STORE_NAME ).getRestBase(),
			message: Object.values( select( STORE_NAME ).getMessage() ),
		};
	} );
	const handleClickMessage = async () => {
		const removedItem = message.shift();

		await apiFetch( {
			path: `${ restBase }/message`,
			method: 'POST',
			data: {
				remove_message: {
					id: removedItem?.id,
					category: removedItem?.category,
				},
			},
		} );

		dispatch( STORE_NAME ).setMessage( message );
	};

	return message.length > 0 ? (
		<>
			<div
				className={
					'wapuugotchi__bubble fade_in_lazy ' +
					message[ 0 ].type +
					'_bubble'
				}
				onClick={ handleClickMessage }
			>
				{ parse( message[ 0 ].message ) }
			</div>
		</>
	) : (
		''
	);
}
