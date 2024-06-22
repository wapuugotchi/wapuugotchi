import './steps.scss';
import Step from "./step";
import {useSelect} from "@wordpress/data";
import { __, sprintf } from '@wordpress/i18n';
import {STORE_NAME} from "../store";

export default function Steps() {
	const { progress, markers } = useSelect( ( select ) => {
		return {
			progress: select( STORE_NAME ).getProgress(),
			markers: select( STORE_NAME ).getMarkers(),
		};
	} );

	function getOrdinal(number) {
		const suffix = ["th", "st", "nd", "rd"];
		return number + (suffix[number] || suffix[0]);
	}

	const getSteps = (progress, markers) => {
		const steps = [];
		for (let i = 1; i <= markers; i++) {
			steps.push(
				<Step key={"wgm_count_" + i} completed={i <= progress ? "true" : "false"} name={
					sprintf(
						__('Find %s clue', 'wapuugotchi'),
						getOrdinal(i)
					)
				} />
			);
		}
		return steps;
	};
	return (
		<>
			<div className="wapuugotchi_missions__steps">
				{getSteps(progress, markers)}
			</div>
			<span className="wapuugotchi_missions__footer">
				{
					sprintf(
						__('Step %1$s of %2$s done, keep on going!', 'wapuugotchi'),
						progress,
						markers
					)
				}
			</span>
		</>
	);
}
