import React, { useEffect, useRef, useState } from '@wordpress/element';

/*
	# about

	this utility react hook can be used to log why a component gets re rendered.
	the tracked changes will be spit out on the js console.

	please use it only for development purposes.

	never keep it in use when pushing to release branch.

	# usage:

	- import the hook into your component:
	import useWhyDidYouUpdate from '../util/whydidyouupdate';

	- call the hook in your component and configure which properties should be tracked:
	// suppose you want to track properties items, wapuu aand svg
	useWhyDidYouUpdate("ShowRoom", { items, wapuu, svg });

*/

export default function useWhyDidYouUpdate( name, props ) {
	// create a reference to track the previous data
	const previousProps = useRef();

	useEffect( () => {
		if ( previousProps.current ) {
			// merge the keys of previous and current data
			const keys = Object.keys( { ...previousProps.current, ...props } );

			// to store what has change
			const changesObj = {};

			// check what values have changed between the previous and current
			keys.forEach( ( key ) => {
				// if both are object
				if (
					typeof props[ key ] === 'object' &&
					typeof previousProps.current[ key ] === 'object'
				) {
					if (
						JSON.stringify( previousProps.current[ key ] ) !==
						JSON.stringify( props[ key ] )
					) {
						// add to changesObj
						changesObj[ key ] = {
							from: previousProps.current[ key ],
							to: props[ key ],
						};
					}
				} else {
					// if both are non-object
					if ( previousProps.current[ key ] !== props[ key ] ) {
						// add to changesObj
						changesObj[ key ] = {
							from: previousProps.current[ key ],
							to: props[ key ],
						};
					}
				}
			} );

			// if changesObj not empty, print the cause
			if ( Object.keys( changesObj ).length ) {
				console.log( 'This is causing re-renders', name, changesObj );
			}
		}

		// update the previous props with the current
		previousProps.current = props;
	} );
}
