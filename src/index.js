import { render } from '@wordpress/element';
import domReady from '@wordpress/dom-ready';
import App from './App';
import { create, STORE_NAME } from './store';
import data from "@wordpress/data";

const id = 'wapuugotchi-app';

domReady( () => render( <App />, document.getElementById( id ) ) );
