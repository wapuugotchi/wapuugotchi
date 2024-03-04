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
class ExportData {

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
		              ->set_page( 'export' )
		              ->set_file( 'export.php' )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Export', 'wapuugotchi' ) )
			                  ->set_text( __( "In the 'Export' section, you can export selected content from your website. This section is the counterpart to importing content.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Usage', 'wapuugotchi' ) )
			                  ->set_text( __( "Exporting content is useful if you want to transfer content from your website to another, or if you need to create a backup of your website.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Overview', 'wapuugotchi' ) )
			                  ->set_text( __( "Here, you have the option to export content from your website. You don’t have to export the entire site; you can choose specific content to export.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#export-filters' )->set_overlay( '#export-filters' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Tip 1', 'wapuugotchi' ) )
			                  ->set_text( __( "Please note that an export can include personal data or copyrighted content. So, be careful about who you share your export with.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Tip 2', 'wapuugotchi' ) )
			                  ->set_text( __( "Also, keep in mind that an export can become quite large, which can be a hassle if you have limited storage in your workspace.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
		              );


		return array_merge( $tour, array( $page ) );
	}
}
