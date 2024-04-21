<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Filters;

use Wapuugotchi\Models\OnboardingItem as Item;
use Wapuugotchi\Models\OnboardingPage as Page;
use Wapuugotchi\Onboarding\Data\OnboardingPage;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;
use function Wapuugotchi\Onboarding\Data\__;
use function Wapuugotchi\Onboarding\Data\add_filter;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class UserData {

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
