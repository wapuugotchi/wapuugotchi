<?php
/**
 * The Missions Class.
 *
 * This class is responsible for adding missions to the WapuuGotchi game.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Mission\Data;

use Wapuugotchi\Mission\Models\Mission;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class Missions
 *
 * Represents the missions in the WapuuGotchi game.
 */
class Missions {
	/**
	 * Adds a mission to the missions array.
	 *
	 * @param array $missions The existing missions.
	 *
	 * @return array The missions array with the new mission added.
	 */
	public static function add_wapuugotchi_filter( array $missions ) {
		$missions[] = Mission::create()
			->set_id( 'endless_steppes' )
			->set_name( __( 'The Endless Steppes', 'wapuugotchi' ) )
			->set_description( __( 'Embark with your brave Wapuu on an adventure through the endless steppes in search of a hidden treasure. But the journey is fraught with dangers and tricky puzzles! Only with your help can your Wapuu overcome these challenges. Support your courageous companion on their journey and together, become the heroes of this adventure!', 'wapuugotchi' ) )
			->set_url( 'https://api.wapuugotchi.com/missions/endless_steppes_1/image.svg' )
			->set_markers(
				array(
					__( 'Wapuu embarks on an adventure through the vast, endless steppes. Soon, he comes across a dense forest where the trees block his way. Carved into the bark of an old tree is a riddle. Only by solving it the hidden path will reveal itself.', 'wapuugotchi' ),
					__( 'After solving the riddle in the forest, Wapuu reaches a massive mountain range. A large monolith blocks the path between the peaks. On its surface is another riddle, and only the correct answer will clear the way.', 'wapuugotchi' ),
					__( 'With the monolith moved aside, Wapuu continues his journey. Suddenly, he comes across a cave, but the entrance is blocked by a giant spider’s web. A spider emerges from the shadows and presents him a new challenge. Only by solving her riddle Wapuu will gain access to the cave.', 'wapuugotchi' ),
					__( 'After passing the spider’s test, Wapuu reaches a peaceful oasis. In the clear water, a glowing fish swims. It promises to show Wapuu the way to the treasure if he can answer the next question correctly.', 'wapuugotchi' ),
					__( 'Wapuu finally finds the treasure. However, a mysterious inscription on the chest says that it will only open if he can solve the final riddle engraved on the lid.', 'wapuugotchi' ),
				)
			)
			->set_reward( 3 );

		return $missions;
	}
}
