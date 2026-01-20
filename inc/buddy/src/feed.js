/**
 * The Feed Class.
 *
 * This class is responsible for managing the two-click mechanism for iframes in the WapuuGotchi feed.
 * It provides methods to initialize the click handlers and load iframes on demand with autoplay support.
 *
 * @package
 */
import "./feed.scss";

export default class Feed {
	init = () => {
		this.bindDelegatedClick();
	};

	bindDelegatedClick = () => {
		document.addEventListener( "click", ( e ) => {
			const placeholder = e.target.closest(
				".wapuugotchi-iframe-placeholder"
			);
			if ( ! placeholder ) {
				return;
			}

			e.preventDefault();
			e.stopPropagation();
			e.stopImmediatePropagation();

			if ( placeholder.querySelector( "iframe" ) ) {
				return;
			}

			const iframeSrc = placeholder.dataset.iframeSrc;
			if ( ! iframeSrc ) {
				return;
			}

			const iframe = document.createElement( "iframe" );
			iframe.src = this.addAutoplayParam( iframeSrc );
			iframe.loading = "lazy";
			iframe.allow = "autoplay; fullscreen";
			iframe.allowFullscreen = true;
			placeholder.appendChild( iframe );
		}, true );
	};

	addAutoplayParam = ( src ) => {
		try {
			const url = new URL( src, window.location.href );
			url.searchParams.set( "autoplay", "1" );
			return url.toString();
		} catch ( error ) {
			const hashIndex = src.indexOf( "#" );
			const base = hashIndex === -1 ? src : src.slice( 0, hashIndex );
			const hash = hashIndex === -1 ? "" : src.slice( hashIndex );
			const separator = base.includes( "?" ) ? "&" : "?";
			return `${ base }${ separator }autoplay=1${ hash }`;
		}
	};
	/**
	 * Waits for an element to appear in the DOM.
	 *
	 * @param {string} selector - The CSS selector of the element to wait for.
	 * @return {Promise} A promise that resolves when the element is found.
	 */
	waitForElement = ( selector ) => {
		const initialElement = document.querySelector( selector );
		if ( initialElement ) {
			return Promise.resolve( initialElement );
		}

		return new Promise( ( resolve ) => {
			const observer = new MutationObserver(
				( mutations, observerInstance ) => {
					mutations.forEach( () => {
						const observedElement =
							document.querySelector( selector );
						if ( observedElement ) {
							observerInstance.disconnect();
							resolve( observedElement );
						}
					} );
				}
			);

			observer.observe( document.getElementById( 'wpbody-content' ), {
				childList: true,
				subtree: true,
			} );
		} );
	};
}

const feed = new Feed();
feed.init();
