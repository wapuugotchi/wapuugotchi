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
class Media {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 200, 1 );
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
					->set_page( 'media' )
					->set_file( 'media-new.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Add New', 'wapuugotchi' ) )
							->set_text( __( 'The "Add New Media File" page lets you upload fresh media like images, videos, or audio files to your media library.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#menu-media .wp-submenu li a.current' )->set_overlay( '#menu-media' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Drag-and-Drop', 'wapuugotchi' ) )
							->set_text( __( 'Adding your media files is a breeze – just drag and drop them into the area, or click the button to select your files. Your new media will be instantly available in your library.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( '#wpcontent' )->set_overlay( '#wpcontent' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'File Info', 'wapuugotchi' ) )
							->set_text( __( 'WordPress supports a bunch of file formats, including images (JPEG, PNG, GIF), videos (MP4, MOV, WMV), audio files (MP3, WAV), and even documents (PDF, DOC, PPT, etc.).', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Upload Tip', 'wapuugotchi' ) )
							->set_text( __( 'You can also add media files directly to your posts or pages while you\'re editing them. Just click the "Add Media" button in the editor.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_active( true )->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
