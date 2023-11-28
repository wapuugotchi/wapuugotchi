import './guide-control.scss';
import closing_guide from './guide-control-dot.svg';


export default function GuideControl() {
	return (
		<>
			<div className="wapuugotchi_onboarding_guide__control">
				<ul>
					<li>
						<button className="components-button has-icon">
							<img src={closing_guide} alt="guide navigation panel"/>
						</button>
					</li>
					<li>
						<button className="components-button has-icon">
							<img src={closing_guide} alt="guide navigation panel"/>
						</button>
					</li>
					<li>
						<button className="components-button has-icon">
							<img src={closing_guide} alt="guide navigation panel"/>
						</button>
					</li>
					<li>
						<button className="components-button has-icon">
							<img src={closing_guide} alt="guide navigation panel"/>
						</button>
					</li>
				</ul>
			</div>
		</>
	);
}
