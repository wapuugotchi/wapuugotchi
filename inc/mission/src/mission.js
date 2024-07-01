import { createRoot, StrictMode } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import Page from './components/page';

const getDomElement = () => {
	let domElement = document.getElementById( 'wapuugotchi-submenu__mission' );
	if ( ! domElement ) {
		domElement = document.createElement( 'DIV' );
		domElement.id = 'wapuugotchi-submenu__mission';
		document.body.prepend( domElement );
	}
	return domElement;
};

domReady( () =>
	createRoot( getDomElement() ).render(
		<StrictMode>
			<div id="wapuugotchi_missions">
				<Page />
			</div>
		</StrictMode>
	)
);
