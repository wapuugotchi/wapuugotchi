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
class ThemeInstallData {

	/**
	 * 'Constructor" of the class
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
						->set_page( 'theme-install' )
						->set_file( 'theme-install.php?browse=popular' )
						->add_item(
							Item::create()
								->set_title( __( 'Add', 'wapuugotchi' ) )
								->set_text( __( 'It might sound crazy, but in the "Add Themes" section, you can... well, add new themes! 😅', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Info', 'wapuugotchi' ) )
								->set_text( __( 'When you enter this section, you\'ll see a selection of the most popular themes. This is super handy since there are more than 10,000 themes to choose from.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Filters', 'wapuugotchi' ) )
								->set_text( __( 'Of course, you can also filter by different categories or search for a specific theme.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '.wp-filter' )->set_overlay( '.wp-filter' ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Inactive Themes', 'wapuugotchi' ) )
								->set_text( __( 'Hover over a theme that catches your eye to switch to its detailed view. In the detailed view, you can find a lot more info, like user reviews.', 'wapuugotchi' ) )
								->add_target( Target::create()->set_active( true )->set_focus( '.theme:not(.active)' )->set_overlay( '.theme:not(.active)' )->set_hover( true ) )
						);

		return array_merge( $tour, array( $page ) );
	}
}
