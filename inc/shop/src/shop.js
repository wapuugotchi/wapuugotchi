import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Container from './components/container';

domReady( () =>
	createRoot( document.getElementById( 'wapuugotchi-submenu__shop' ) ).render(
		<StrictMode>
			<Container />
		</StrictMode>
	)
);
