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
class Themes {

	/**
	 * 'Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 300, 1 );
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
					->set_page( 'themes' )
					->set_file( 'themes.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Design', 'wapuugotchi' ) )
							->set_text( __( 'Welcome to the submenu of the "Appearance" main menu item. This is where you can manage the appearance and visual presentation of your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-appearance' )->set_overlay( '#menu-appearance' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Themes', 'wapuugotchi' ) )
							->set_text( __( 'The "Themes" page lets you change the design of your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-appearance .wp-submenu li a.current' )->set_overlay( '#menu-appearance' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'On the overview page, you\'ll find a list of all installed themes. Here, you can also see the active theme currently used on your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Active Themes', 'wapuugotchi' ) )
							->set_text( __( 'Here, you see the active theme. This theme determines the design of your website. This is what your visitors are seeing when they visit your website right now.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.theme.active' )->set_overlay( '.theme.active' )->set_hover( true ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Inactive Themes', 'wapuugotchi' ) )
							->set_text( __( 'There are also themes that are installed but not active. You can switch between them by activating an inactive theme, which would then change the design of your website accordingly.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.theme:not(.active)' )->set_overlay( '.theme:not(.active)' )->set_hover( true ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Search', 'wapuugotchi' ) )
							->set_text( __( 'Use this search feature to look for a specific theme that you\'ve already installed.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wp-filter-search-input' )->set_overlay( '#wp-filter-search-input' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Install', 'wapuugotchi' ) )
							->set_text( __( 'You can also install new themes. Let\'s take a look at how to do that.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.wrap a' )->set_overlay( '.wrap a' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
