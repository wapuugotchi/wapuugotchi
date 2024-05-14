<?php
/**
 * The AnimationHandler Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Alive\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Handles all animation related tasks.
 */
class AnimationHandler {

	/**
	 * remove all animations from avatar.
	 *
	 * @param $avatar
	 *
	 * @return array|mixed
	 */
	public static function extract_animations( $avatar ) {
		if ( false === $avatar ) {
			return $avatar;
		}

		$domDocument = new \DOMDocument();
		$domDocument->loadXML( $avatar );

		if ( empty( $domDocument->textContent ) ) {
			return $avatar;
		}

		$styleElements = $domDocument->getElementsByTagName( 'style' );
		if ( false === $styleElements instanceof \DOMNodeList || 0 === $styleElements->length ) {
			return $avatar;
		}

		$animations = array();
		foreach ( $styleElements as $styleElement ) {
			$animations[] = preg_replace('/\s+/', ' ', trim($styleElement->nodeValue));
		}

		do_action( 'animations_extracted', $animations );

		// Remove all style elements
		while ( $styleElement = $styleElements->item( 0 ) ) {
			$styleElement->parentNode->removeChild( $styleElement );
		}

		return $domDocument->saveHTML();
	}

}
