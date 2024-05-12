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
class User {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 450, 1 );
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
					->set_page( 'user' )
					->set_file( 'user-new.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Introduction', 'wapuugotchi' ) )
							->set_text( __( 'Welcome to the "Add New User" page. Here, you can add users and manage their roles.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-users' )->set_overlay( '#menu-users' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 1', 'wapuugotchi' ) )
							->set_text( __( 'This page is pretty self-explanatory. But be extra careful with assigning roles, as they determine the permissions a user has!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 2', 'wapuugotchi' ) )
							->set_text( __( 'Even the "Author" role, in the wrong hands, can cause significant damage to your website, as users with this role can write and publish posts.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#role' )->set_overlay( '#role' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 3', 'wapuugotchi' ) )
							->set_text( __( 'An Administrator can revoke rights from all users... including you! So, be cautious about whom you assign the "Administrator" role.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#role' )->set_overlay( '#role' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
