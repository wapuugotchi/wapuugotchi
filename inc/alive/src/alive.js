export default class Alive {
	constructor(animations) {
		if (!Array.isArray(animations)) {
			return;
		}

		this.animations = animations;
		this.init();
	}

	/**
	 * Wartet, bis ein bestimmtes Element im DOM vorhanden ist.
	 * @param {string} selector - Der CSS-Selektor des Elements, auf das gewartet wird.
	 * @returns {Promise} - Ein Promise, das sich auflöst, wenn das Element gefunden wird.
	 */
	waitForElement(selector) {
		return new Promise((resolve) => {
			// Überprüfen, ob das Element bereits existiert
			const element = document.querySelector(selector);
			if (element) {
				resolve(element);
				return;
			}

			// Erstellen eines MutationObservers, um das DOM zu überwachen
			const observer = new MutationObserver((mutations, observerInstance) => {
				mutations.forEach(() => {
					// Überprüfen, ob das Element jetzt existiert
					const element = document.querySelector(selector);
					if (element) {
						observerInstance.disconnect();
						resolve(element);
					}
				});
			});

			// Konfigurieren des Observers
			observer.observe(document.body, {
				childList: true,
				subtree: true
			});
		});
	}

	/**
	 * Initialisiert die Klasse, indem sie auf das Vorhandensein des Elements wartet und dann die Animationen hinzufügt.
	 */
	init() {
		this.waitForElement('#wapuugotchi_type__wapuu').then(element => {
			this.animations.map((animation) => {
				let style = document.createElement('style');
				style.innerHTML = animation;
				element.prepend(style);
			});
		});
	}
}

new Alive(wapuugotchiAnimations);
