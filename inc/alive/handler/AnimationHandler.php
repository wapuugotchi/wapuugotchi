<?php
/**
 * The AnimationHandler Class.
 *
 * This class is responsible for handling all tasks related to animations.
 * It provides a method to extract animations from an avatar.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Alive\Handler;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * The AnimationHandler Class.
 *
 * This class is responsible for handling all tasks related to animations.
 * It provides a method to extract animations from an avatar.
 *
 * @package WapuuGotchi
 */
class AnimationHandler {

	/**
	 * Extracts all animations from the avatar and returns them.
	 *
	 * This method takes an avatar as input and extracts all animations from it.
	 * The extracted animations are returned in an array.
	 * If the avatar is empty or contains no animations, the avatar is returned unchanged.
	 *
	 * @param string $avatar The avatar from which the animations should be extracted.
	 *
	 * @return array|string An array with the extracted animations or the unchanged avatar if no animations were found.
	 */
	public static function extract_animations( $avatar ) {
		if ( false === $avatar ) {
			return $avatar;
		}

		$dom_document = new \DOMDocument();
		$dom_document->loadXML( $avatar );

		// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
		if ( empty( $dom_document->textContent ) ) {
			return $avatar;
		}

		$style_elements = $dom_document->getElementsByTagName( 'style' );
		if ( false === $style_elements instanceof \DOMNodeList || 0 === $style_elements->length ) {
			return $avatar;
		}

		$animations = array();
		foreach ( $style_elements as $style_element ) {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$animations[] = preg_replace( '/\s+/', ' ', trim( $style_element->nodeValue ) );
		}

		do_action( 'animations_extracted', $animations );

		// Remove all style elements.
		while ( $style_element = $style_elements->item( 0 ) ) {
			// phpcs:ignore WordPress.NamingConventions.ValidVariableName.UsedPropertyNotSnakeCase
			$style_element->parentNode->removeChild( $style_element );
		}

		return $dom_document->saveHTML();
	}
}
