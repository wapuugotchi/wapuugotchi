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
class OptionsGeneralData {

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
						->set_page( 'options-general' )
						->set_file( 'options-general.php' )
						->add_item(
							Item::create()
								->set_title( __( 'Settings', 'wapuugotchi' ) )
								->set_text( __( 'Right now, we\'re checking out the submenu of the "Settings" main menu item. These pages allow you to set up the general settings for your website.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-settings' )->set_overlay( '#menu-settings' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'General', 'wapuugotchi' ) )
								->set_text( __( 'The "General" page is the first page you see when you enter "Settings". Here, you can set your website\'s name, URL, timezone, and date format.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-settings .wp-submenu li a.current' )->set_overlay( '#menu-settings' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Useful to Know', 'wapuugotchi' ) )
								->set_text( __( 'The settings you establish here are really important as they form the foundation of your website. So, you should carefully review and set these settings.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
