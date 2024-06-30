import './overlay.scss';
import Svg from './svg';
import { useEffect, useState } from "@wordpress/element";
import Loader from "./loader";
export default function Overlay() {
	const [loading, setLoading] = useState(false);

	useEffect(() => {
		const hideAction = (event) => {
			console.log(event.target)
			if(event.target.id ==='wapuugotchi_quiz__overlay' || event.target.id ==='wapuugotchi_quiz__svg') {
				setLoading(true);
				location.reload();
			}
		};

		document.querySelector('#wapuugotchi_quiz__overlay')?.addEventListener('click', hideAction);
		console.log(document.querySelector('#wapuugotchi_quiz__overlay svg'))

	}, []);

	return (
		<>
			<div id="wapuugotchi_quiz__overlay">
				{(!loading) ? <Svg /> : <Loader />}
			</div>
		</>
	);
}
