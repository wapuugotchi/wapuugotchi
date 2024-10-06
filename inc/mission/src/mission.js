// Importieren der notwendigen Bibliotheken und Komponenten
import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Page from './components/page';

/**
 * Ermittelt das DOM-Element für die Mission oder erstellt es, falls nicht vorhanden.
 * @return {HTMLElement} Das DOM-Element für die Mission.
 */
const getDomElement = () => {
	// Versuche, das bestehende Element zu finden
	let domElement = document.getElementById( 'wapuugotchi-submenu__mission' );

	// Falls nicht vorhanden, erstelle ein neues DIV-Element und füge es dem Body hinzu
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi-submenu__mission';
		document.body.prepend( domElement );
	}

	return domElement;
};

// Warte auf das DOM-Ready-Ereignis, um die React-Komponente zu rendern
domReady( () =>
	createRoot( getDomElement() ).render(
		<StrictMode>
			<div id="wapuugotchi_missions">
				<Page />
			</div>
		</StrictMode>
	)
);
