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
class ExportPersonalDataData {

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
		              ->set_page( 'export-personal-data' )
		              ->set_file( 'export-personal-data.php' )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Export Personal Data', 'wapuugotchi' ) )
			                  ->set_text( __( "In the 'Export Personal Data' section, you can specifically export the personal data of your users.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Overview', 'wapuugotchi' ) )
			                  ->set_text( __( "Here, you have the option to export the personal data of a specific user. This is useful if a user wants to take their data with them, like when they're switching websites.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Tip 1', 'wapuugotchi' ) )
			                  ->set_text( __( "Make sure to only pass the data to the user it belongs to. This is crucial for complying with privacy regulations and to avoid legal issues.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
		              );


		return array_merge( $tour, array( $page ) );
	}
}
