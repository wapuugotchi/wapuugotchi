import { render, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Log from './components/questlog/log';

domReady( () =>
	render(
		<StrictMode>
			<Log />
		</StrictMode>,
		document.getElementById( 'wapuugotchi-app' )
	)
);
