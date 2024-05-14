import { STORE_NAME } from './store';
import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Example from "./components/example";

const getDomElement = () => {
	let domElement = document.getElementById( 'wpbody-content' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi__avatar';
		document.getElementById( 'wpwrap' ).append( domElement );
	}
	return domElement;
};

domReady( () =>
	createRoot( getDomElement() ).render(
		<StrictMode>
			<Example />
		</StrictMode>
	)
);
