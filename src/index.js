import { render, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Avatar from './components/avatar/avatar';

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
	render(
		<StrictMode>
			<Avatar />
		</StrictMode>,
		getDomElement()
	)
);
