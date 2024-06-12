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
class Upload {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 175, 1 );
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
					->set_page( 'upload' )
					->set_file( 'upload.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Media', 'wapuugotchi' ) )
							->set_text( __( 'We\'re now in the submenu of the "Media" main menu item. This is where you manage all the media files you add to your posts or pages.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-media' )->set_overlay( '#menu-media' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Media Overview', 'wapuugotchi' ) )
							->set_text( __( 'First up, let\'s check out your "Library". Here, you\'ll see a summary of all the media you\'ve uploaded so far.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-media .wp-submenu li a.current' )->set_overlay( '#menu-media' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Media Library', 'wapuugotchi' ) )
							->set_text( __( 'All uploaded media is stored here. You\'ll get a visual of all these files with thumbnails, file info, and metadata like titles, descriptions, and alt texts for images.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'div.media-frame-tab-panel' )->set_overlay( 'div.media-frame-tab-panel' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Details', 'wapuugotchi' ) )
							->set_text( __( 'You can also edit the details of your media here. Change file names, add extra information, or tweak the metadata.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'div.attachments-wrapper' )->set_overlay( 'div.attachments-wrapper' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Filtering and Search', 'wapuugotchi' ) )
							->set_text( __( 'Use filter and search features to quickly find specific media items.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'div.media-toolbar' )->set_overlay( 'div.media-toolbar' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Uploading', 'wapuugotchi' ) )
							->set_text( __( 'Here\'s where you can upload new media to your library. Just click the button and drag-and-drop your files in with ease.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( 'a.page-title-action' )->set_overlay( 'a.page-title-action' ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
