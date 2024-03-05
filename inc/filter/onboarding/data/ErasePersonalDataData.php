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
class ErasePersonalDataData {

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
						->set_page( 'erase-personal-data' )
						->set_file( 'erase-personal-data.php' )
						->add_item(
							Item::create()
								->set_title( __( 'Erase Personal Data', 'wapuugotchi' ) )
								->set_text( __( "In the 'Erase Personal Data' section, you can delete a user's personal data. Let's take a closer look anyway.", 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Overview', 'wapuugotchi' ) )
								->set_text( __( 'Basically, this page is set up just like the personal data export page. Here, you have the option to delete the personal data of a specific user.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Usage', 'wapuugotchi' ) )
								->set_text( __( "There might be situations where a user wants their data deleted. This could be the case if they're switching websites or for other reasons no longer want their data stored on your site.", 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
