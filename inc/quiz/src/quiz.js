import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Main from './components/main';

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi_mission__action' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi_mission__action';
		document.querySelector('#wpcontent').appendChild( domElement );
	}
	return domElement;
};

domReady( () =>
	createRoot( getDomElement() ).render(
		<StrictMode>
			<Main />
		</StrictMode>
	)
);
