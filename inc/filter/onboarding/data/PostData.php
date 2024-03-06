<?php
/**
 * The QuestContent Class.
 *
 * @package WapuuGotchi
 */

namespace Wapuugotchi\Onboarding\Data;

use Wapuugotchi\Models\OnboardingItem as Item;
use Wapuugotchi\Models\OnboardingPage as Page;
use Wapuugotchi\Wapuugotchi\OnboardingTarget as Target;

if ( ! defined( 'ABSPATH' ) ) :
	exit();
endif; // No direct access allowed.

/**
 * Class QuestContent
 */
class PostData {

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
						->set_page( 'post' )
						->set_file( 'post-new.php' )
						->add_item(
							Item::create()
								->set_title( __( 'Just a Moment', 'wapuugotchi' ) )
								->set_text( __( "Hang tight, we're almost through the Gutenberg tutorial. I'll give you a bit more of a tour afterward.", 'wapuugotchi' ) )
								->add_target( Target::create()->set_focus( null )->set_overlay( null ) )
						)
						->add_item(
							Item::create()
								->set_title( __( 'Tutorial Time', 'wapuugotchi' ) )
								->set_text( __( 'Now we\'re in the "Add New" section of the "Posts" area. As you learnt in the tutorial, you can add all your posts for your website from here.', 'wapuugotchi' ) )
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
								->set_text( __( 'The toolbar offers features to build your post step by step. Add new block elements and undo changes. Wanna see how it works? Hit "Play"!', 'wapuugotchi' ) )
								->set_freeze( 38000 )
								->add_target( Target::create()->set_focus( '.edit-post-header__toolbar' )->set_overlay( '.edit-post-header__toolbar' ) )
								->add_target( Target::create()->set_focus( '.edit-post-header__toolbar' )->set_overlay( '.edit-post-header__toolbar' )->set_delay( 0 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '.edit-post-header__toolbar' )->set_overlay( '.edit-post-header__toolbar' )->set_delay( 500 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '.edit-post-header-toolbar__left' )->set_overlay( '.edit-post-header-toolbar__left' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( 'button.edit-post-header-toolbar__inserter-toggle' )->set_overlay( 'button.edit-post-header-toolbar__inserter-toggle' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( 'button.edit-post-header-toolbar__inserter-toggle' )->set_overlay( 'button.edit-post-header-toolbar__inserter-toggle' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( 'button.edit-post-header-toolbar__inserter-toggle[aria-pressed="false"]' ) )
								->add_target( Target::create()->set_focus( 'button.edit-post-header-toolbar__inserter-toggle' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '.interface-interface-skeleton__secondary-sidebar' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 4000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( 'button.editor-block-list-item-table' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( 'button.editor-block-list-item-table' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' )->set_click( 'button.editor-block-list-item-table' ) )
								->add_target( Target::create()->set_focus( '.block-editor-block-list__block.wp-block-table' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 4000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '.editor-history__undo' ) )
								->add_target( Target::create()->set_focus( '.editor-history__redo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '.editor-history__redo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '.editor-history__redo' ) )
								->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( '.editor-history__undo' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( '.editor-history__undo' ) )
								->add_target( Target::create()->set_focus( 'button.edit-post-header-toolbar__inserter-toggle' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 2000 )->set_color( '#FF0000' ) )
								->add_target( Target::create()->set_focus( 'button.edit-post-header-toolbar__inserter-toggle' )->set_overlay( '.interface-interface-skeleton__editor' )->set_delay( 1000 )->set_color( '#FF0000' )->set_click( 'button.edit-post-header-toolbar__inserter-toggle[aria-pressed="true"]' ) )
								->add_target( Target::create()->set_focus( '.edit-post-header__toolbar' )->set_overlay( '.edit-post-header__toolbar' )->set_delay( 4000 ) )
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
								->set_title( __( 'Content Area', 'wapuugotchi' ) )
								->set_text( __( 'In the content area, you can edit your contents, write texts, insert images, and edit blocks. Unleash your creativity!', 'wapuugotchi' ) )
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