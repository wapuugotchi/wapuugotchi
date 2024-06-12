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
class OptionsMedia {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 800, 1 );
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
					->set_page( 'options-media' )
					->set_file( 'options-media.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Media', 'wapuugotchi' ) )
							->set_text( __( 'The "Media" page deals with the basic settings for managing media files on your website.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-settings .wp-submenu li a.current' )->set_overlay( '#menu-settings' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Overview', 'wapuugotchi' ) )
							->set_text( __( 'Here, you can set up how your media files are managed. For instance, you can define how media files should be organized and the size of the thumbnails.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 1', 'wapuugotchi' ) )
							->set_text( __( 'Be careful not to choose too large a size for your thumbnails, as it can negatively impact your website\'s loading time.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tip 2', 'wapuugotchi' ) )
							->set_text( __( 'Also, make sure to organize your media files sensibly. This is especially useful if you have a lot of media files.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
