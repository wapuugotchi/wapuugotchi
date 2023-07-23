import { render, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import MenuHeader from './components/menu-header';

domReady( () =>
	render(
		<StrictMode>
			<MenuHeader title="mops" description="klops" />
		</StrictMode>,
		document.getElementById( 'wapuugotchi-app' )
	)
);
