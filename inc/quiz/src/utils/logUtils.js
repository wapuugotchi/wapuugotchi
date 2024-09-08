import { useEffect } from '@wordpress/element';

const logClickEvent = ( event ) => {
	console.log( 'Element clicked:', event.target );
};

useEffect( () => {
	// Attach the click event listener to the document
	document.addEventListener( 'click', logClickEvent );

	// Cleanup the event listener on component unmount
	return () => {
		document.removeEventListener( 'click', logClickEvent );
	};
}, [] );
