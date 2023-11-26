import { render, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Shop from './components/shop/shop';

domReady( () =>
	render(
		<StrictMode>
			<Shop />
		</StrictMode>,
		document.getElementById( 'wapuugotchi-app' )
	)
);
