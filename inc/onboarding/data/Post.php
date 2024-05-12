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
class Post {

	/**
	 * "Constructor" of the class
	 */
	public function __construct() {
		\add_filter( 'wapuugotchi_onboarding_filter', array( $this, 'add_wapuugotchi_filter' ), 100, 1 );
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
					->set_page( 'post' )
					->set_file( 'post-new.php' )
					->add_item(
						Item::create()
							->set_title( __( 'Just a Moment', 'wapuugotchi' ) )
							->set_text( __( 'Hang tight, we\'re almost through the Gutenberg editor tutorial. I\'ll give you a bit more of a tour afterward.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( null )->set_overlay( null ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Tutorial Time', 'wapuugotchi' ) )
							->set_text( __( 'Now we\'re on the "Add New" page. As you learnt in the tutorial, you can add all your posts for your website from here.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '#menu-posts .wp-submenu li a.current' )->set_overlay( '#menu-posts' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Top Navigation', 'wapuugotchi' ) )
							->set_text( __( 'The top navigation gives you quick access to essential controls in the editor. It\'s split into the toolbar and the settings bar.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '.interface-navigable-region.interface-interface-skeleton__header' )->set_overlay( '.interface-navigable-region.interface-interface-skeleton__header' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'The Toolbar', 'wapuugotchi' ) )
							->set_text( __( 'The toolbar offers features to build your post step by step. Add new block elements and undo changes. Wanna see how it works? Hit the ► button!', 'wapuugotchi' ) )
							->set_freeze( 24000 )
							->add_target( Target::create()->set_focus( '.edit-post-header__toolbar' )->set_overlay( '.edit-post-header__toolbar' ) )
							->add_target( Target::create()->set_focus( '.edit-post-header__toolbar' )->set_overlay( '.edit-post-header__toolbar' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.edit-post-header-toolbar' )->set_overlay( '.edit-post-header-toolbar' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( 'button.editor-document-tools__inserter-toggle' )->set_overlay( 'button.editor-document-tools__inserter-toggle' )->set_delay( 2000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( 'button.editor-document-tools__inserter-toggle' )->set_overlay( 'button.editor-document-tools__inserter-toggle' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( 'button.editor-document-tools__inserter-toggle[aria-pressed="false"]' ) )
							->add_target( Target::create()->set_focus( '.interface-interface-skeleton__secondary-sidebar' )->set_overlay( '.interface-interface-skeleton__secondary-sidebar' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.interface-interface-skeleton__secondary-sidebar' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( 'button.editor-block-list-item-table' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( 'button.editor-block-list-item-table' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' )->set_click( 'button.editor-block-list-item-table' ) )
							->add_target( Target::create()->set_focus( 'button.editor-document-tools__inserter-toggle' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( 'button.editor-document-tools__inserter-toggle' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( 'button.editor-document-tools__inserter-toggle[aria-pressed="true"]' ) )
							->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '.editor-history__undo' ) )
							->add_target( Target::create()->set_focus( '.editor-history__redo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.editor-history__redo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '.editor-history__redo' ) )
							->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' ) )
							->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '.editor-history__undo' ) )
							->add_target( Target::create()->set_focus( '.edit-post-header__toolbar' )->set_overlay( '.edit-post-header__toolbar' )->set_delay( 2000 ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Settings Bar', 'wapuugotchi' ) )
							->set_text( __( 'In the settings bar, you can save and publish your post. Plus, you can switch between different screen modes like desktop, mobile, and tablet.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '.edit-post-header__settings' )->set_overlay( '.edit-post-header__settings' )->set_click( '.interface-pinned-items button[aria-expanded="false"]' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Side Navigation', 'wapuugotchi' ) )
							->set_text( __( 'Here you\'ll find additional information about your blog post and can make settings on individual blocks.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '.interface-interface-skeleton__sidebar' )->set_overlay( '.interface-interface-skeleton__sidebar' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Content Part', 'wapuugotchi' ) )
							->set_text( __( 'In the content part, you can edit your contents, write texts, insert images, and edit blocks. Unleash your creativity!', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( '.interface-interface-skeleton__content' )->set_overlay( '.interface-interface-skeleton__content' )->set_click( '.interface-pinned-items button[aria-expanded="false"]' ) )
					)
					->add_item(
						Item::create()
							->set_title( __( 'Wrapping Up', 'wapuugotchi' ) )
							->set_text( __( 'The text editor has loads of features, and I\'m sure I forgot to explain half of them! Hope I at least gave you a good start.', 'wapuugotchi' ) )
							->add_target( Target::create()->set_focus( null )->set_overlay( null ) )
					);

		return array_merge( $tour, array( $page ) );
	}
}
