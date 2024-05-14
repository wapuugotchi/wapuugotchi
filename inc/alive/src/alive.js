export default class Alive {
	constructor( animations ) {
		if ( ! Array.isArray( animations ) ) {
			return;
		}

		this.animations = animations;
		this.init();
	}

	/**
	 * Wartet, bis ein bestimmtes Element im DOM vorhanden ist.
	 * @param {string} selector - Der CSS-Selektor des Elements, auf das gewartet wird.
	 * @return {Promise} - Ein Promise, das sich auflöst, wenn das Element gefunden wird.
	 */
	waitForElement( selector ) {
		return new Promise( ( resolve ) => {
			// Überprüfen, ob das Element bereits existiert
			const initialElement = document.querySelector( selector );
			if ( initialElement ) {
				resolve( initialElement );
				return;
			}

			// Erstellen eines MutationObservers, um das DOM zu überwachen
			const observer = new MutationObserver(
				( mutations, observerInstance ) => {
					mutations.forEach( () => {
						// Überprüfen, ob das Element jetzt existiert
						const observedElement =
							document.querySelector( selector );
						if ( observedElement ) {
							observerInstance.disconnect();
							resolve( observedElement );
						}
					} );
				}
			);

			// Konfigurieren des Observers
			observer.observe( document.getElementById( 'wpbody-content' ), {
				childList: true,
				subtree: true,
			} );
		} );
	}
	/**
	 * Initialisiert die Klasse, indem sie auf das Vorhandensein des Elements wartet und dann die Animationen hinzufügt.
	 */
	init() {
		this.waitForElement( '#wapuugotchi_type__wapuu' ).then( ( element ) => {
			this.animations.forEach( ( animation ) => {
				const style = document.createElement( 'style' );
				style.innerHTML = animation;
				element.prepend( style );
			} );
		} );
	}
}

/**
 * wapuugotchiAnimations is set by wp_add_inline_script() in inc/alive/Manager.php
 */
/* global wapuugotchiAnimations */
new Alive( wapuugotchiAnimations );
