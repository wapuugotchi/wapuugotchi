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
class Users {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 425, 1 );
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
					->set_page( 'users' )
					->set_file( 'users.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Introduction', 'wapuugotchi' ) )
							->set_text( __( 'We\'re in the submenu that falls under the "Users" main menu item. Here, you can manage the users of your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-users' )->set_overlay( '#menu-users' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'All Users', 'wapuugotchi' ) )
							->set_text( __( 'In the "All Users" page, you can see and manage all the users of your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-users .wp-submenu li a.current' )->set_overlay( '#menu-users' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'On the overview page, you\'ll find a list of all users who are registered on your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'User Details', 'wapuugotchi' ) )
							->set_text( __( 'Each user is displayed in a table. Apart from their username, you can also see their email address and user role.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'table' )->set_overlay( 'table' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'User Actions', 'wapuugotchi' ) )
							->set_text( __( 'When you hover over a user, a menu appears. Here, you can edit or delete a user. Give it a try!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'table #the-list tr' )->set_overlay( 'table #the-list tr' )->set_hover( true ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Filter User Groups', 'wapuugotchi' ) )
							->set_text( __( 'Here, you can filter by user groups. This is especially useful if you have many users. The filter is dynamic and shows only the user groups that actually exist.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'ul.subsubsub' )->set_overlay( 'ul.subsubsub' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Search for Users', 'wapuugotchi' ) )
							->set_text( __( 'Of course, you also have the option to search for specific users and roles. This is handy when you have many users.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'p.search-box' )->set_overlay( 'p.search-box' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Add New User', 'wapuugotchi' ) )
							->set_text( __( 'Here\'s where you can add new users. Let\'s check it out!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'a.page-title-action' )->set_overlay( 'a.page-title-action' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
