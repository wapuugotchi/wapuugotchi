import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Avatar from './components/avatar';
import Bubble from './components/bubble';

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi__avatar' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi__avatar';
		document.getElementById( 'wpbody-content' ).append( domElement );
	}
	return domElement;
};

domReady( () =>
	createRoot( getDomElement() ).render(
		<StrictMode>
			<Bubble />
			<Avatar />
		</StrictMode>
	)
);
