import { StrictMode, createRoot } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Log from './components/questlog/log';

domReady( () =>
	createRoot( document.getElementById( 'wapuugotchi-app' ) ).render(
		<StrictMode>
			<Log />
		</StrictMode>
	)
);
