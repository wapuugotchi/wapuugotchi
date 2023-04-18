import { useState } from "@wordpress/element";
import Shop from "./components/shop";
import { STORE_NAME } from "./store";
import { useSelect } from "@wordpress/data";
import apiFetch from "@wordpress/api-fetch";

// Example POST request for unlocking a wearable
// apiFetch( {
// 	path: '/wapuugotchi/v1/wearable',
// 	method: 'POST',
// 	data: { uuid: '2d8d2920-e2a4-4460-9945-0403a4c1f869' },
// } ).then( ( res ) => {
// 	console.log( res );
// } );

// POST
/*
apiFetch( {
	path: '/wapuugotchi/v1/wearable',
	method: 'POST',
	data: { uuid: '18442df1-58ee-4440-95e7-524f6d051e0a' },
} ).then( ( res ) => {
	console.log( res );
} );
*/

export default function App() {
	// const { wapuu, collections, categories } = useSelect( select => {
	// 	return {
	// 		collections: select(STORE_NAME).getCollections(),
	// 		wapuu: select(STORE_NAME).getWapuu(),
	// 		categories: select(STORE_NAME).getCategories(),
	// 	};
	// });

	return <Shop />;
}
