import ShowRoom from './show-room';
import ControlPanel from './control-panel';
import './left-side.scss';

export default function LeftSide() {
	return (
		<div className="wapuugotchi_shop__customizer_left">
			<ShowRoom />
			<ControlPanel />
		</div>
	);
}
