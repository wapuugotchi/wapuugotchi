import { StrictMode, createRoot } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Log from './components/questlog/log';

domReady( () =>
createRoot( document.getElementById( 'wapuugotchi__questlog' ) ).render(
		<StrictMode>
			<Log />
		</StrictMode>
	)
);
