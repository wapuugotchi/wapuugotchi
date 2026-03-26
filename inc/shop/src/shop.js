import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import { dispatch } from '@wordpress/data';
import { STORE_NAME } from './store';
import Container from './components/container';

if ( window.wapuugotchiShopData ) {
	dispatch( STORE_NAME ).__initialize( window.wapuugotchiShopData );
}

domReady( () =>
	createRoot( document.getElementById( 'wapuugotchi-submenu__shop' ) ).render(
		<StrictMode>
			<Container />
		</StrictMode>
	)
);
