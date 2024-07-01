import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Svg from './components/svg';

domReady( () => {
	const waitForElement = ( selector ) => {
		const initialElement = document.querySelector( selector );
		if ( initialElement ) {
			return Promise.resolve( initialElement );
		}

		return new Promise( ( resolve ) => {
			const observer = new MutationObserver(
				( mutations, observerInstance ) => {
					mutations.forEach( () => {
						const observedElement =
							document.querySelector( selector );
						if ( observedElement ) {
							observerInstance.disconnect();
							resolve( observedElement );
						}
					} );
				}
			);

			observer.observe( document.getElementById( 'wpbody-content' ), {
				childList: true,
				subtree: true,
			} );
		} );
	};

	waitForElement( '.wapuugotchi_mission__overlay' ).then( ( element ) => {
		createRoot( element ).render(
			<StrictMode>
				<Svg />
			</StrictMode>
		);
	} );
} );
