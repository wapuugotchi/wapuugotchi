import './steps.scss';
import Step from './step';
import { useSelect, useDispatch } from '@wordpress/data';
import { __, sprintf } from '@wordpress/i18n';
import { STORE_NAME } from '../store';
import { useEffect } from '@wordpress/element';

export default function Steps() {
	const { setProgress } = useDispatch( STORE_NAME );

	const { progress, markers, completed } = useSelect( ( select ) => {
		return {
			progress: select( STORE_NAME ).getProgress(),
			markers: select( STORE_NAME ).getMarkers(),
			completed: select( STORE_NAME ).getCompleted(),
		};
	} );

	useEffect( () => {
		if ( completed === true ) {
			setProgress( progress + 1 );
		}
	}, [ completed ] );

	function getOrdinal( number ) {
		const suffix = [ 'th', 'st', 'nd', 'rd' ];
		return number + ( suffix[ number ] || suffix[ 0 ] );
	}

	const getSteps = ( progressData, markersData ) => {
		const steps = [];
		for ( let i = 1; i <= markersData; i++ ) {
			steps.push(
				<Step
					key={ 'wgm_count_' + i }
					completed={ i <= progressData ? 'true' : 'false' }
					name={ sprintf(
						// translators: %s: step number
						__( 'Find %s clue', 'wapuugotchi' ),
						getOrdinal( i )
					) }
				/>
			);
		}
		return steps;
	};
	return (
		<>
			<div className="wapuugotchi_missions__steps">
				{ getSteps( progress, markers ) }
			</div>
			<span className="wapuugotchi_missions__footer">
				{ sprintf(
					// translators: %1$s: current step, %2$s: total steps.
					__(
						'Step %1$s of %2$s done, keep on going!',
						'wapuugotchi'
					),
					progress,
					markers
				) }
			</span>
		</>
	);
}
