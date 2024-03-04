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
class ThemeEditorData {

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
		              ->set_page( 'theme-editor' )
		              ->set_file( 'theme-editor.php' )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Edit Themes', 'wapuugotchi' ) )
			                  ->set_text( __( "The 'Edit Themes' section allows you to modify the files of your theme.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Overview', 'wapuugotchi' ) )
			                  ->set_text( __( "Here, you can make direct changes to the files of your theme. You should have some programming knowledge if you're going to hang out in this section.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Warning', 'wapuugotchi' ) )
			                  ->set_text( __( "Heads up! Editing files can damage your website. If you're not sure what you're doing, it's better to steer clear of this.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
		              );


		return array_merge( $tour, array( $page ) );
	}
}
