import { createRoot, render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import App from './App';

const id = 'wapuugotchi-app';

domReady( function () {
	const root = createRoot( document.getElementById( id ) )
	root.render( <App />);
} );
