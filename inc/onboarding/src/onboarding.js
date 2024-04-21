import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Main from './components/main';

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi__onboarding' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi__onboarding';
		document.body.prepend( domElement );
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
