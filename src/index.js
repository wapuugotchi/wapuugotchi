import { render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import App from './App';

const id = 'wapuugotchi-app';

domReady( function () {
	render( <App />, document.getElementById( id ) );
} );
