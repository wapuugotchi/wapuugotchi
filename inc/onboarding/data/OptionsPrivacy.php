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
class OptionsPrivacy {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 850, 1 );
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
					->set_page( 'options-privacy' )
					->set_file( 'options-privacy.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Privacy', 'wapuugotchi' ) )
							->set_text( __( 'The "Privacy" page is designed for managing your website\'s privacy policies.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-settings .wp-submenu li a.current' )->set_overlay( '#menu-settings' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'This page allows you to ensure that your website complies with privacy policies and legal requirements. There are also plugins available that provide additional support.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 1', 'wapuugotchi' ) )
							->set_text( __( 'Privacy policies are crucial, especially if your website collects personal data from users through comments, forms, etc. This helps protect you from legal issues.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 2', 'wapuugotchi' ) )
							->set_text( __( 'If you\'re having trouble sleeping, consider reading the "Policy Guide" on privacy statements. It always puts me to sleep in seconds!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '.privacy-settings-header a:not(.active)' )->set_overlay( '.privacy-settings-header a:not(.active)' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
