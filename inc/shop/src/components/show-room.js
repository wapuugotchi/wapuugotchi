import { STORE_NAME } from '../store';
import { useSelect } from '@wordpress/data';
import { useEffect, useState } from '@wordpress/element';
import './show-room.scss';

export default function ShowRoom() {
	const { svg } = useSelect( ( select ) => {
		return {
			svg: select( STORE_NAME ).getSvg(),
		};
	} );

	const [avatar, setAvatar] = useState(svg);

	useEffect(() => {
		setAvatar(svg);
	}, [svg]);

	return (
		<div className="wapuugotchi_shop__image">
			<div className="wapuu_show_room">
				<svg
					xmlns="http://www.w3.org/2000/svg"
					x="0"
					y="0"
					version="1.1"
					viewBox="0 0 1000 1000"
					dangerouslySetInnerHTML={ { __html: avatar } }
				></svg>
			</div>
		</div>
	);
}
