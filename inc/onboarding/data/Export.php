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
class Export {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 550, 1 );
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
					->set_page( 'export' )
					->set_file( 'export.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Export', 'wapuugotchi' ) )
							->set_text( __( 'On the "Export" page, you can transfer your website\'s content to a different location. This is a crucial task, so let\'s do it with care.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-tools .wp-submenu li a.current' )->set_overlay( '#menu-tools' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Usage', 'wapuugotchi' ) )
							->set_text( __( 'Exporting content is like moving your website\'s content to a new home. It\'s also a great way to keep a backup of your website, just in case!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'Here, you can select what content to transfer. You don\'t have to move everything, you can choose specific items to transfer!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#export-filters' )->set_overlay( '#export-filters' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 1', 'wapuugotchi' ) )
							->set_text( __( 'Just a little reminder, your content might contain personal data or things that belong to someone else. So, be careful about who you share your content with, okay?', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 2', 'wapuugotchi' ) )
							->set_text( __( 'Also, remember that if you transfer a lot of content, it can take up a lot of space. Make sure you have enough room in your workspace to store it!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
