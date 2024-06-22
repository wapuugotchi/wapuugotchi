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
			//->set_url( \plugin_dir_url( __DIR__ ) . 'assets/maps/endless_steppes.svg' )
			->set_url( 'https://wapuugotchi.com/wp-content/uploads/2024/06/endless_steppes_2.svg' )
			->set_markers( 5 )
			->set_reward( 3 );

		return $missions;
	}
}
