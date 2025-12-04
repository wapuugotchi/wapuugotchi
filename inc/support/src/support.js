import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import App from './components/app';
import './store';

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi-submenu__support' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi-submenu__support';
		document.body.prepend( domElement );
	}
	return domElement;
};

domReady( () =>
	createRoot( getDomElement() ).render(
		<StrictMode>
			<App />
		</StrictMode>
	)
);
