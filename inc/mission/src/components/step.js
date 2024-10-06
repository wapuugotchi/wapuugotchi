import './step.scss';

/**
 * Step-Komponente, die einen Schritt in der Missionsliste anzeigt.
 * @param {Object} props           - Die Eigenschaften der Komponente.
 * @param {string} props.completed - Der Abschlussstatus des Schritts.
 * @param {string} props.name      - Der Name des Schritts.
 * @return {Object} Die Step-Komponente.
 */
export default function Step( { completed, name } ) {
	// Dynamische Klassenname-Zuweisung basierend auf dem Abschlussstatus
	const stepClassName = `wapuugotchi_missions__step ${
		completed === 'true' ? 'completed' : ''
	}`;

	return (
		<>
			<div className={ stepClassName }>
				<div className="wapuugotchi_missions__step_name">{ name }</div>
				<div className="wapuugotchi_missions__step_bar" />
			</div>
		</>
	);
}
