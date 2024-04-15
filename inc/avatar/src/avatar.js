import { StrictMode, createRoot } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Avatar from './components/avatar';

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi__avatar' );
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
			<Avatar />
		</StrictMode>
	)
);
