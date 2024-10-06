import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Svg from './components/svg';

/**
 * Wartet auf das Erscheinen eines Elements im DOM und gibt dieses zurück.
 * @param {string} selector - Der CSS-Selektor des zu wartenden Elements.
 * @return {Promise<Element>} Ein Promise, das das gefundene Element zurückgibt.
 */
const waitForElement = async ( selector ) => {
	const element = document.querySelector( selector );
	if ( element ) {
		return element;
	}

	return new Promise( ( resolve ) => {
		const observer = new MutationObserver( ( mutations, obs ) => {
			const targetElement = document.querySelector( selector );
			if ( targetElement ) {
				obs.disconnect();
				resolve( targetElement );
			}
		} );

		observer.observe( document.getElementById( 'wpbody-content' ), {
			childList: true,
			subtree: true,
		} );
	} );
};

/**
 * Initialisiert die Anwendung, sobald das DOM bereit ist.
 */
domReady( async () => {
	// Warte auf das Overlay-Element, bevor die Anwendung gerendert wird.
	const element = await waitForElement( '.wapuugotchi_mission__overlay' );

	// Erstelle einen React-Root und rendere die Svg-Komponente im StrictMode.
	createRoot( element ).render(
		<StrictMode>
			<Svg />
		</StrictMode>
	);
} );
