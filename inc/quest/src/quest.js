import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Log from './components/log';

domReady( () =>
	createRoot(
		document.getElementById( 'wapuugotchi-submenu__quests' )
	).render(
		<StrictMode>
			<Log />
		</StrictMode>
	)
);
