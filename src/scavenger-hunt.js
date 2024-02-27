import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import MenuHeader from './components/shop/menu-header';

domReady( () =>
	createRoot( document.getElementById( 'wapuugotchi-app' ) ).render(
		<StrictMode>
			<MenuHeader title="mops" description="klops" />
		</StrictMode>
	)
);
