import { render, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Main from "./components/onboarding/main";

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi__onboarding' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi__onboarding';
		document.getElementById( 'wpcontent' ).append( domElement );
	}
	return domElement;
};

domReady( () =>
	render(
		<StrictMode>
			<Main />
		</StrictMode>,
		getDomElement()
	)
);
