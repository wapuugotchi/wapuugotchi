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
class ErasePersonalData {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 625, 1 );
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
					->set_page( 'erase-personal-data' )
					->set_file( 'erase-personal-data.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Erase Personal Data', 'wapuugotchi' ) )
							->set_text( __( 'On the "Erase Personal Data" page, you can delete a user\'s personal data. Let\'s take a closer look together!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'This page is pretty much like the personal data export page. Here, you can delete a specific user\'s personal data.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Usage', 'wapuugotchi' ) )
							->set_text( __( 'Sometimes, a user might want their data deleted. Maybe they\'re switching websites or they just don\'t want their data on your website anymore.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'form table.wp-list-table' )->set_overlay( 'form table.wp-list-table' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Deleting Data', 'wapuugotchi' ) )
							->set_text( __( 'Please note, when you erase a user\'s data, you\'re also erasing all data associated with them. This includes their comments, posts, and any other personal details. That\'s pretty important!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Data Protection Tip', 'wapuugotchi' ) )
							->set_text( __( 'Remember, less data means less worry! If you don\'t have it, it can\'t be stolen. Simple, isn\'t it?', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
