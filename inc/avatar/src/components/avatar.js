import {STORE_NAME} from '../store';
import {useSelect} from '@wordpress/data';
import {useMemo} from 'react';
import './avatar.scss';

export default function Avatar() {
	const {avatar} = useSelect((select) => {
		return {
			avatar: select(STORE_NAME).getAvatar(),
		};
	});

	const memoizedAvatar = useMemo(() => avatar, [avatar]);

	return (
		<div className="wapuugotchi__svg">
			<svg
				xmlns="http://www.w3.org/2000/svg"
				x="0"
				y="0"
				version="1.1"
				viewBox="0 0 1000 1000"
				dangerouslySetInnerHTML={{__html: memoizedAvatar}}
			></svg>
		</div>
	);
}
