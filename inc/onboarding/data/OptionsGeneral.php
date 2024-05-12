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
class OptionsGeneral {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 700, 1 );
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
