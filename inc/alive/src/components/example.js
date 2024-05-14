import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';

export default function Example() {
	const { animations } = useSelect( ( select ) => {
		return {
			animations: select( STORE_NAME ).getAnimations(),
		};
	} );

	return (
		<div>
			{
				animations.map( ( animation, index ) => (
					<p key={ index }>{ animation }</p>
				) )
			}
		</div>
	);
}
