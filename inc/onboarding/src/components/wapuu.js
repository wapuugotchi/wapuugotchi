import { useSelect } from '@wordpress/data';
import { STORE_NAME } from '../store';

export default function Wapuu() {
	const { avatar } = useSelect( ( select ) => {
		return {
			avatar: select( STORE_NAME ).getAvatar(),
		};
	} );

	return (
		<svg
			xmlns="http://www.w3.org/2000/svg"
			height="100%"
			width="700px"
			version="1.1"
			viewBox="-820 0 1000 770"
			dangerouslySetInnerHTML={ { __html: avatar } }
		></svg>
	);
}
