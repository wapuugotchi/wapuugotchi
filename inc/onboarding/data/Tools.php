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
class Tools {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 500, 1 );
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
					->set_page( 'tools' )
					->set_file( 'tools.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Tools', 'wapuugotchi' ) )
							->set_text( __( 'We\'ve just moved into the submenu of the "Tools" main menu item. This page provides additional functions and resources, especially for administrators. Let\'s take a quick look.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools' )->set_overlay( '#menu-tools' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Available Tools', 'wapuugotchi' ) )
							->set_text( __( 'This is the "Available Tools" page. Here you\'ll find a list of tools that can help you manage your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'This is the overview page for available tools. Here, you can see and manage the tools available to you. They vary depending on the plugins you have installed and your WordPress version.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
