import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Hidden from './components/hidden';

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi__seek' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi__seek';
		document.getElementById( 'wpwrap' ).append( domElement );
	}
	return domElement;
};

domReady( () =>
	createRoot( getDomElement() ).render(
		<StrictMode>
			<Hidden />
		</StrictMode>
	)
);
