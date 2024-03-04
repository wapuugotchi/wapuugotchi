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
class OptionsReadingData {

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
		              ->set_page( 'options-reading' )
		              ->set_file( 'options-reading.php' )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Reading', 'wapuugotchi' ) )
			                  ->set_text( __( "The 'Reading' section allows you to set basic display settings for your website.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#menu-settings .wp-submenu li a.current' )->set_overlay( '#menu-settings' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Overview', 'wapuugotchi' ) )
			                  ->set_text( __( "Here, you can set up the settings for your homepage and posts page. You can also decide how many posts should be displayed on the homepage.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Homepage', 'wapuugotchi' ) )
			                  ->set_text( __( "Setting a static homepage allows you to customize the front page of your website. This is particularly useful if you're running a business website or a landing page.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#front-static-pages' )->set_overlay( '#front-static-pages' ) )
		              )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Search Engines', 'wapuugotchi' ) )
			                  ->set_text( __( "You might notice that despite using SEO plugins, visitors aren't coming through search engines. This could be because you've disabled search engine indexing here.", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
		              );


		return array_merge( $tour, array( $page ) );
	}
}
