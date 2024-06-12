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
class Profile {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 475, 1 );
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
					->set_page( 'profile' )
					->set_file( 'profile.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Introduction', 'wapuugotchi' ) )
							->set_text( __( 'Welcome to the "Profile" page. Let\'s keep it brief: here, you can edit your profile. And on we go!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-users' )->set_overlay( '#menu-users' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Wrap-Up', 'wapuugotchi' ) )
							->set_text( __( 'And just like that, we\'re done with another page. Users bring life to your website but also pose certain risks. So be careful about who you give what rights to.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip', 'wapuugotchi' ) )
							->set_text( __( 'One last tip: there are plugins that enable two-factor authentication. It\'s an extra layer of security I highly recommend.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
