<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Models\OnboardingItem as Item;
use Wapuugotchi\Models\OnboardingPage as Page;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class ToolsData {

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
						->set_page( 'tools' )
						->set_file( 'tools.php' )
						->add_item(
							Item::create()
								->set_title( __( 'Tools', 'wapuugotchi' ) )
								->set_text( __( "Welcome to the 'Tools' section. This area provides additional functions and resources, especially for administrators. Let's take a quick look.", 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools' )->set_overlay( '#menu-tools' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Available Tools', 'wapuugotchi' ) )
								->set_text( __( "This is the 'Available Tools' section. Here you'll find a list of tools that can help you manage your website.", 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Overview', 'wapuugotchi' ) )
								->set_text( __( 'This is the overview page for available tools. Here, you can see and manage the tools available to you. They vary depending on the plugins you have installed and your WordPress version.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
