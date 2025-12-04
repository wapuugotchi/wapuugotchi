<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Onboarding\Models\Guide;
use Wapuugotchi\Onboarding\Models\Item;
use Wapuugotchi\Onboarding\Models\Target;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class TourQuestContent
 */
class TourWapuugotchiMission {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 1000, 1 );
	}

	/**
	 * Init and add a guide item to the array of items.
	 *
	 * @param array $tour Array of onboarding objects.
	 *
	 * @return Guide[]
	 */
	public function add_wapuugotchi_filter( $tour ) {
		$page = Guide::create()
					->set_page( 'toplevel_page_wapuugotchi' )
					->set_file( 'admin.php?page=wapuugotchi' )
					->add_item(
						Item::create()
							->set_title( __( 'Mission Overview', 'wapuugotchi' ) )
							->set_text( __( 'Ready for adventure? Every day brings you fresh, fun challenges — your daily Missions! Complete them to earn Perls and unlock awesome items and unique skins for your Wapuu. Dive in, explore, and level up your WordPress knowledge along the way.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#toplevel_page_wapuugotchi .current' )->set_overlay( '#toplevel_page_wapuugotchi' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Mission Map', 'wapuugotchi' ) )
							->set_text( __( 'This map shows your Wapuu’s current adventure. Keep track of your progress and start the next mission step by clicking the green pointer. Each time you complete a map, a new one is revealed — so there’s always more to explore!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.wapuugotchi_missions__map' )->set_overlay( '.wapuugotchi_missions__map' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Refresh', 'wapuugotchi' ) )
							->set_text( __( 'Need a fresh start? In the top WapuuGotchi menu, you’ll find a special button — only visible on this Mission page. Use it to reset your current Mission if something gets stuck or if you want to explore a brand-new map right away!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wp-admin-bar-wapuugotchi_admin_bar_menu' )->set_overlay( '#wp-admin-bar-wapuugotchi_admin_bar_menu' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Last Word', 'wapuugotchi' ) )
							->set_text( __( 'Your turn now: Dive into your WordPress world, take on fun missions, and enjoy the journey!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
