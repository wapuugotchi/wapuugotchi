import {cloneElement, createElement, useCallback, useState, useRef } from "@wordpress/element";
import { STORE_NAME, store } from "../store";
import { useSelect, subscribe } from '@wordpress/data';
import "./Avatar.css";
import "./Animation.css"

function Avatar() {
	const { svg } = useSelect( select => {
		return {
			svg: 	 	select(STORE_NAME).getSvg(),
		}
	});

	return (
		<svg xmlns="http://www.w3.org/2000/svg" x="0" y="0" version="1.1" viewBox="140 100 700 765"
				 dangerouslySetInnerHTML={{__html: svg}}></svg>
	);

};
export default Avatar;
