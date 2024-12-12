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

		$missions[] = Mission::create()
		                     ->set_id( 'burning_rivers' )
		                     ->set_name( __( 'The Burning Rivers', 'wapuugotchi' ) )
		                     ->set_description( __( 'Join your brave Wapuu on a daring journey through the burning rivers, where the air shimmers with heat and every choice matters. Treacherous currents and challenging puzzles await to test your resolve! Only with your support can your Wapuu overcome the dangers ahead. Stand by your courageous companion and together, craft a heroic tale that begins in the burning rivers!', 'wapuugotchi' ) )
		                     ->set_url( 'https://api.wapuugotchi.com/missions/burning_rivers_1/image.svg' )
		                     ->set_markers(
			                     array(
				                     __( 'Wapuu ventures deeper into the burning rivers and discovers a dark cave. The entrance is guarded by fiery bats, and inside, a mysterious glow reveals a riddle carved into the stone walls. Solving it is the key to proceeding further.', 'wapuugotchi' ),
				                     __( 'Leaving the cave, Wapuu finds himself at the base of a towering volcano. The ground trembles with every step, and molten rocks block the path. To proceed, he must solve the riddle etched into an ancient, lava-scorched tablet.', 'wapuugotchi' ),
				                     __( 'The volcano\'s riddle solved, Wapuu carefully crosses a raging lava flow. A series of stepping stones appear, but only the correct answer to the fiery question will light the way.', 'wapuugotchi' ),
				                     __( 'On the other side of the lava flow, a mighty Fire Golem rises from the ground. Its burning eyes pierce through the haze as it poses a challenging riddle to Wapuu. Only by answering it can the Golem be calmed.', 'wapuugotchi' ),
				                     __( 'With the Fire Golem appeased, Wapuu reaches the final destination: a glowing treasure chest made of sparkling diamonds. Yet, an intricate fiery inscription on the chest demands one last riddle to be solved before the treasure can be claimed.', 'wapuugotchi' ),
			                     )
		                     )
		                     ->set_reward( 3 );

		return $missions;
	}
}
