import './map.scss';
import {useSelect} from "@wordpress/data";
import {STORE_NAME} from "../store";

export default function Map() {
	const { map } = useSelect( ( select ) => {
		return {
			map: select( STORE_NAME ).getMap(),
		};
	} );
	return (
		<>
			<div className="wapuugotchi_missions__map">
				{console.log(map)}
				{map === null ? '' : <img src={map} alt="Missions" /> }
			</div>
		</>
	);
}
