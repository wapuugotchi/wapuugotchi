// Importieren der notwendigen Styles und Komponenten
import './description.scss';
import Pearls from './pearls';
import { useSelect } from '@wordpress/data';
import { __ } from '@wordpress/i18n';
import { STORE_NAME } from '../store';

/**
 * Description-Komponente, die die Missionsbeschreibung anzeigt.
 * Nutzt den globalen Store, um die Beschreibung der aktuellen Mission zu erhalten.
 */
export default function Description() {
	// Verwendung des useSelect-Hooks, um die Beschreibung aus dem Store zu extrahieren
	const { description } = useSelect( ( select ) => ( {
		description: select( STORE_NAME ).getDescription(),
	} ) );

	// Render-Funktion, die die Beschreibung und zusätzliche Komponenten anzeigt
	return (
		<>
			<div className="wapuugotchi_missions__description">
				<div className="wapuugotchi_missions__headline">
					<h2>{ __( 'Current adventure', 'wapuugotchi' ) }</h2>
					<Pearls />
				</div>
				<p>{ description }</p>
			</div>
		</>
	);
}
