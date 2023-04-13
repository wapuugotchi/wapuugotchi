import domReady from "@wordpress/dom-ready";
import { render, StrictMode } from "@wordpress/element";
import Avatar from "./components/Avatar";

let div = document.createElement("DIV");
div.id = "wapuugotchi__avatar";
document.getElementById("wpwrap").append(div);
domReady(() => render( <StrictMode><Avatar/></StrictMode>, document.getElementById( 'wapuugotchi__avatar' )));
