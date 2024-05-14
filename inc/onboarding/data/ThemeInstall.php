<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Onboarding\Models\Guide;
use Wapuugotchi\Onboarding\Models\Item;
use Wapuugotchi\Onboarding\Models\Target;

if ( ! defined( 'ABSPATH' ) ) {
	exit();
}

/**
 * Class QuestContent
 */
class ThemeInstall {

	/**
	 * 'Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 325, 1 );
	}

	/**
	 * Init and add a guide item to the array of items.
	 *
	 * @param array $tour Array of onboarding objects.
	 *
	 * @return Guide[]
	 */
	public function add_wapuugotchi_filter( $tour ) {
		$page = Guide::create()
					->set_page( 'theme-install' )
					->set_file( 'theme-install.php?browse=popular' )
					->add_item(
						Item::create()
							->set_title( __( 'Add', 'wapuugotchi' ) )
							->set_text( __( 'It might sound crazy, but on the "Add Themes" page, you can... well, add new themes!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Info', 'wapuugotchi' ) )
							->set_text( __( 'When you enter this page, you\'ll see a selection of the most popular themes. This is super handy since there are more than 10,000 themes to choose from.', 'wapuugotchi' ) )
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
