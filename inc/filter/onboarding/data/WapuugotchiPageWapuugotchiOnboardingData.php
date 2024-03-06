<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Models\OnboardingItem as Item;
use Wapuugotchi\Models\OnboardingPage as Page;
use Wapuugotchi\Wapuugotchi\Onboarding;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class WapuugotchiPageWapuugotchiOnboardingData {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ) );
	}

	/**
	 * Initialization filter for OnboardingData
	 *
	 * @param array $tour Array of onboarding objects.
	 *
	 * @return array|OnboardingPage[]
	 */
	public function add_wapuugotchi_filter( $tour ) {
		$page[] = Page::create()
						->set_page( 'wapuugotchi_page_wapuugotchi-onboarding' )
						->set_file( 'admin.php?page=wapuugotchi-onboarding' )
						->add_item(
							Item::create()
								->set_title( __( 'Welcome Aboard!', 'wapuugotchi' ) )
								->set_text( __( 'Hey there! Welcome to your journey through the WordPress universe! I\'m super excited to guide you through your first steps in WordPress. First things first, we\'re diving into two essentials: the Admin Bar and the Sidebar. Let\'s go!', 'wapuugotchi' ) )
								->add_target( Target::create() )
						)
						->add_item(
							Item::create()
								->set_title( __( 'The Admin-Bar', 'wapuugotchi' ) )
								->set_text( __( 'First stop, the Admin-Bar! This is your quick access lane to key areas and info. You\'ll also get a snapshot of pending updates and comments here.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_focus( '#wpadminbar' )->set_overlay( '#wpadminbar' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Navigating the Site', 'wapuugotchi' ) )
								->set_text( __( 'The Sidebar makes hopping between different areas of your site a breeze. Each main area has several subsections, which we\'ll call "sections" from here on.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_focus( '#adminmenuwrap' )->set_overlay( '#adminmenuwrap' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Tip 1', 'wapuugotchi' ) )
								->set_text( __( 'Quick heads-up: Want a clearer view of your side? You can always collapse the sidebar. Neat trick, right?', 'wapuugotchi' ) )
								->set_freeze( 5500 )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_click( '#collapse-button' )->set_delay( 1000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '#collapse-button' )->set_overlay( '#collapse-button' )->set_delay( 500 ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Navigating the Site', 'wapuugotchi' ) )
								->set_text( __( 'Let\'s take a closer look at each area and there sections. We\'ll uncover the ins and outs, showing you how every part plays its role in the grand WordPress scheme. Ready to explore?', 'wapuugotchi' ) )
								->add_target( Target::create()->set_focus( '#adminmenuwrap' )->set_overlay( '#adminmenuwrap' ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
