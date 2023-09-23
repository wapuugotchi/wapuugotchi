import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';
import './show-room.scss';

export default function ShowRoom() {
	const { svg, animations } = useSelect( ( select ) => {
		return {
			svg: select( STORE_NAME ).getSvg(),
			animations: select( STORE_NAME ).getAnimations(),
		};
	} );

	return (
		<div className="wapuu_show_room">
			{ /*		changes to the ViewBox can destroy the animations.		*/ }
			<svg
				xmlns="http://www.w3.org/2000/svg"
				id="wapuugotchi_svg__wapuu"
				x="0"
				y="0"
				version="1.1"
				viewBox="0 0 1000 1000"
				dangerouslySetInnerHTML={ { __html: svg } }
			></svg>
		</div>
	);
}
