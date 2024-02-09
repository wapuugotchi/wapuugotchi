import {createRoot, StrictMode} from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Shop from './components/shop/shop';

domReady( () =>
	createRoot( document.getElementById( 'wapuugotchi-app' ) ).render(
		<StrictMode>
			<Shop />
		</StrictMode>
	)
);
