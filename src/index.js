import React from 'react'
import ReactDOM from "react-dom/client";
import App from './App';

const id = 'wapuugotchi-app';

document.addEventListener( 'DOMContentLoaded', function() {
  const element = document.getElementById( id );
  if( typeof element !== 'undefined' && element !== null ) {
    const root = ReactDOM.createRoot(document.getElementById(id));
    root.render( <App />);
  }
} );