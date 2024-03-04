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
class SiteEditorData {

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
		              ->set_page( 'site-editor' )
		              ->set_file( 'site-editor.php' )
		              ->add_item(
			              Item::create()
			                  ->set_title( __( 'Comments', 'wapuugotchi' ) )
			                  ->set_text( __( "To be totally honest? I'm not sure... But I'll take care of it!", 'wapuugotchi' ) )
			                  ->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
		              );


		return array_merge( $tour, array( $page ) );
	}
}
