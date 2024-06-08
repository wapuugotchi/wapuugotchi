/**
 * The Alive Class.
 *
 * This class is responsible for managing the animations in the WapuuGotchi plugin.
 * It provides methods to initialize the animations, animate the avatar, and handle CSS rules.
 *
 * @package
 */
export default class Alive {
	/**
	 * Initializes the animations.
	 *
	 * @param {Array} animations The animations to initialize.
	 */
	init = ( animations ) => {
		if ( ! Array.isArray( animations ) || animations.length === 0 ) {
			return;
		}

		this.animations = animations;
		this.animateAvatar();
	};

	/**
	 * Starts the animation of the avatar.
	 */
	animateAvatar = () => {
		this.waitForElement( '#wapuugotchi_type__wapuu' ).then( ( element ) => {
			if ( ! element ) {
				return;
			}
			const animate = () => {
				const styles = Array.from(
					element.querySelectorAll( 'style' )
				);
				styles.forEach( ( style ) => style.remove() );

				const animationIndex = Math.floor(
					Math.random() * this.animations.length
				);
				const animation = this.animations[ animationIndex ];

				const style = document.createElement( 'style' );
				element.appendChild( style );
				style.appendChild( document.createTextNode( animation ) );

				const rules = style.sheet.cssRules;
				if ( ! ( rules instanceof CSSRuleList ) ) {
					element.removeChild( style );
					return;
				}

				const delay = this.getMinDelay( rules );
				Array.from( rules ).forEach( ( rule ) => {
					if ( ! ( rule instanceof CSSStyleRule ) ) {
						return;
					}
					rule.style.animationDelay = `${
						parseFloat( rule.style.animationDelay ) - delay
					}s`;
				} );

				this.duration = Math.floor(
					this.getMaxDuration( rules ) + ( Math.random() * 15 + 5 )
				);
				setTimeout( animate, this.duration * 1000 );
			};

			animate();
		} );
	};

	/**
	 * Gets the maximum duration from a set of CSS rules.
	 *
	 * @param {CSSRuleList} rules - The CSS rules to be checked.
	 * @return {number} The maximum duration.
	 */
	getMaxDuration = ( rules ) => {
		if ( ! ( rules instanceof CSSRuleList ) ) {
			return 0;
		}

		const durations = Array.from( rules )
			.filter( ( rule ) => rule instanceof CSSStyleRule )
			.map( ( rule ) => parseFloat( rule.style.animationDuration ) )
			.filter( ( duration ) => ! isNaN( duration ) );
		return Math.max( ...durations );
	};

	/**
	 * Gets the minimum delay from a set of CSS rules.
	 *
	 * @param {CSSRuleList} rules - The CSS rules to be checked.
	 * @return {number} The minimum delay.
	 */
	getMinDelay = ( rules ) => {
		if ( ! ( rules instanceof CSSRuleList ) ) {
			return 0;
		}

		const delays = Array.from( rules )
			.filter( ( rule ) => rule instanceof CSSStyleRule )
			.map( ( rule ) => parseFloat( rule.style.animationDelay ) )
			.filter( ( delay ) => ! isNaN( delay ) );
		return Math.min( ...delays );
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

/* global wapuugotchiAnimations */
const alive = new Alive();
alive.init( wapuugotchiAnimations );
