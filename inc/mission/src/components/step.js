import './step.scss';

export default function Step( props ) {
	return (
		<>
			<div className={"wapuugotchi_missions__step " + (props?.completed === "true" ? "completed" : "")}>
				<div className="wapuugotchi_missions__step_name">{props?.name}</div>
				<div className="wapuugotchi_missions__step_bar" />
			</div>
		</>
	);
}
