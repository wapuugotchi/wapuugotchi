import './page.scss';
import Map from "./map";
import Description from "./description";
import Steps from "./steps";

export default function Page() {
	return (
		<>
			<div className="wapuugotchi_missions__page">
				<Map />
				<Description />
				<Steps />
			</div>
		</>
	);
}
